<?php

namespace Tests;

use Anthropic\Client;
use Anthropic\Core\BaseClient;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Exceptions\RetryableException;
use Anthropic\Middleware;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Exercises the `(request, callNext)` middleware pipeline behavior by behavior:
 * request rewriting, short-circuiting, programmatic retry, chain nesting and
 * per-attempt signing, error-response visibility, the body-restoration
 * contract, exception handling, the RetryableException retry signal, streaming
 * routing, and reach through the beta service.
 *
 * @internal
 */
#[CoversNothing]
final class MiddlewareTest extends TestCase
{
    #[Test]
    public function testClassFormMiddlewareRewritesTheRequest(): void
    {
        // A class implementing the Middleware interface works wherever a
        // callable does, and a request it rewrites reaches the transport.
        $transporter = $this->transporter();
        $mw = new class() implements Middleware {
            public bool $ran = false;

            public function handle(RequestInterface $request, \Closure $callNext): ResponseInterface
            {
                $this->ran = true;

                return $callNext($request->withHeader('X-Trace-Id', 'trace-123'));
            }
        };

        $this->baseClient([$mw], $transporter)->request('GET', '/');

        $this->assertTrue($mw->ran);
        $this->assertSame('trace-123', $this->lastRequest($transporter)->getHeaderLine('X-Trace-Id'));
    }

    #[Test]
    public function testShortCircuitSkipsTransport(): void
    {
        // Returning a response without calling callNext (e.g. a cache hit) means
        // the transport is never reached.
        $transporter = $this->transporter();
        $cached = $this->response(200, '{"cached":true}');
        $mw = $this->mw(
            static fn (RequestInterface $req, \Closure $next): ResponseInterface => $cached,
        );

        $this->baseClient([$mw], $transporter)->request('GET', '/');

        $this->assertCount(0, $transporter->getRequests());
    }

    #[Test]
    public function testProgrammaticRetryResendsTheBody(): void
    {
        // A middleware can retry by calling callNext again, keyed off response
        // content. Each send transmits the full request body — the seekable body
        // is rewound between sends — and the SDK returns the retried response.
        $bodies = [];
        $record = static function (string $body) use (&$bodies): void {
            $bodies[] = $body;
        };
        $transporter = new class($record, [
            $this->response(200, '{"should_retry":true}'),
            $this->response(200, '{"ok":true}'),
        ]) implements ClientInterface {
            private int $i = 0;

            /** @param list<ResponseInterface> $queue */
            public function __construct(private \Closure $record, private array $queue) {}

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                ($this->record)((string) $request->getBody());

                return $this->queue[$this->i++];
            }
        };

        $finalBody = null;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$finalBody): ResponseInterface {
                $rsp = $next($req);
                if (str_contains((string) $rsp->getBody(), '"should_retry":true')) {
                    $rsp = $next($req);
                }
                $finalBody = (string) $rsp->getBody();

                return $rsp;
            },
        );

        $options = RequestOptions::with(
            transporter: $transporter,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            middleware: [$mw],
        );
        $client = new class(headers: [], baseUrl: 'http://localhost', options: $options) extends BaseClient {};

        $client->request('POST', '/', body: '{"x":1}');

        // Both sends carried the full body; the retried response came back.
        $this->assertSame(['{"x":1}', '{"x":1}'], $bodies);
        $this->assertSame('{"ok":true}', $finalBody);
    }

    #[Test]
    public function testChainNestingAndPerAttemptSigning(): void
    {
        // The chain nests in registration order — per-request middleware runs
        // inside client-level middleware — and the per-attempt request transform
        // (Bedrock/Vertex signing) runs beneath all of them: every middleware
        // sees the canonical request; only the transport receives the signed one.
        $transporter = $this->transporter();
        $order = [];
        $sawSigned = [];
        $tag = function (string $name) use (&$order, &$sawSigned): callable {
            return $this->mw(
                static function (RequestInterface $req, \Closure $next) use ($name, &$order, &$sawSigned): ResponseInterface {
                    $order[] = "{$name}-before";
                    $sawSigned[$name] = $req->hasHeader('X-Signed');
                    $rsp = $next($req);
                    $order[] = "{$name}-after";

                    return $rsp;
                },
            );
        };

        $record = static function (string $marker) use (&$order): void {
            $order[] = $marker;
        };
        $options = RequestOptions::with(
            transporter: $transporter,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            middleware: [$tag('client')],
        );
        // A client whose transformRequest() signs the request (as Bedrock/Vertex
        // do, per attempt) and records when it runs relative to the middleware.
        $client = new class($record, $options) extends BaseClient {
            private \Closure $record;

            public function __construct(\Closure $record, RequestOptions $options)
            {
                $this->record = $record;
                parent::__construct(headers: [], baseUrl: 'http://localhost', options: $options);
            }

            protected function transformRequest(RequestInterface $request): RequestInterface
            {
                ($this->record)('transform');

                return $request->withHeader('X-Signed', '1');
            }
        };

        $client->request('GET', '/', options: ['middleware' => [$tag('request')]]);

        // Every middleware saw the canonical request — signing happens deeper.
        $this->assertFalse($sawSigned['client']);
        $this->assertFalse($sawSigned['request']);
        // Registration order nests, with transform innermost (one send).
        $this->assertSame(
            ['client-before', 'request-before', 'transform', 'request-after', 'client-after'],
            $order,
        );
        // The transport receives the signed request.
        $this->assertSame('1', $this->lastRequest($transporter)->getHeaderLine('X-Signed'));
    }

    #[Test]
    public function testErrorResponsesAreVisibleBeforeTheSdkRaises(): void
    {
        // callNext returns the response for *every* HTTP status, so middleware
        // can inspect a 4xx; only after the chain unwinds does the SDK raise.
        $transporter = $this->transporter($this->response(404));
        $seenStatus = null;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$seenStatus): ResponseInterface {
                $rsp = $next($req);
                $seenStatus = $rsp->getStatusCode();

                return $rsp;
            },
        );

        try {
            $this->baseClient([$mw], $transporter)->request('GET', '/');
            $this->fail('expected APIStatusException');
        } catch (APIStatusException) {
            // expected
        }

        $this->assertSame(404, $seenStatus);
    }

    #[Test]
    public function testMiddlewareMustRestoreTheBodyAfterReading(): void
    {
        // A middleware that reads the response body consumes the stream. The
        // contract: restore it before returning — by rewinding the consumed
        // stream or returning a fresh one via withBody() — so the SDK can decode.
        $rewind = $this->mw(
            static function (RequestInterface $req, \Closure $next): ResponseInterface {
                $rsp = $next($req);
                (string) $rsp->getBody(); // consume
                $rsp->getBody()->rewind(); // restore by rewinding

                return $rsp;
            },
        );
        $replace = $this->mw(
            static function (RequestInterface $req, \Closure $next): ResponseInterface {
                $rsp = $next($req);
                $read = (string) $rsp->getBody(); // consume

                return $rsp->withBody( // restore by replacing
                    Psr17FactoryDiscovery::findStreamFactory()->createStream($read),
                );
            },
        );

        foreach ([$rewind, $replace] as $mw) {
            $parsed = $this->baseClient([$mw], $this->transporter($this->response(200, '{"ok":true}')))
                ->request('GET', '/', convert: 'mixed')
                ->parse()
            ;
            $this->assertSame(['ok' => true], $parsed);
        }
    }

    #[Test]
    public function testMiddlewareExceptionDiscrimination(): void
    {
        // A PSR-18 transport exception surfaces as APIConnectionException (the
        // original kept as `previous`); any other exception propagates unchanged.
        // Neither is retried, and neither reaches the transport.
        $transporter = $this->transporter();

        $psr18 = new class('kaboom') extends \RuntimeException implements ClientExceptionInterface {};
        $psr18Mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use ($psr18): ResponseInterface {
                throw $psr18;
            },
        );
        try {
            $this->baseClient([$psr18Mw], $transporter)->request('GET', '/');
            $this->fail('expected APIConnectionException');
        } catch (APIConnectionException $e) {
            $this->assertSame($psr18, $e->getPrevious());
        }

        $plain = new \RuntimeException('middleware boom');
        $plainMw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use ($plain): ResponseInterface {
                throw $plain;
            },
        );
        try {
            $this->baseClient([$plainMw], $transporter)->request('GET', '/');
            $this->fail('expected RuntimeException');
        } catch (\RuntimeException $e) {
            $this->assertSame($plain, $e); // unchanged, not wrapped
        }

        $this->assertCount(0, $transporter->getRequests());
    }

    #[Test]
    public function testRetryableExceptionRecoversThenExhausts(): void
    {
        // Throwing RetryableException opts the attempt back into the retry policy
        // (the usual backoff, bounded by maxRetries). A transient one recovers on
        // a later attempt; one that persists past maxRetries surfaces as-is.
        $transporter = $this->transporter();
        $attempts = 0;
        $recover = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$attempts): ResponseInterface {
                if (0 === $attempts++) {
                    throw new RetryableException('transient');
                }

                return $next($req);
            },
        );

        $rsp = $this->baseClient([$recover], $transporter, initialRetryDelay: 0.0)->request('GET', '/');

        $this->assertSame(200, $rsp->getStatusCode());
        // Only the second (non-throwing) attempt reached the transport.
        $this->assertCount(1, $transporter->getRequests());

        $boom = new RetryableException('always');
        $attempts = 0;
        $exhaust = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$attempts, $boom): ResponseInterface {
                ++$attempts;

                throw $boom;
            },
        );

        try {
            $this->baseClient([$exhaust], $this->transporter(), maxRetries: 2, initialRetryDelay: 0.0)->request('GET', '/');
            $this->fail('expected RetryableException');
        } catch (RetryableException $e) {
            $this->assertSame($boom, $e); // surfaces as-is, not wrapped
        }

        // Initial attempt plus 2 retries.
        $this->assertSame(3, $attempts);
    }

    #[Test]
    public function testStreamingRoutesThroughTheChainUntouched(): void
    {
        // Streaming requests flow through the same chain. The streaming-vs-plain
        // transporter selection happens *inside* callNext (after middleware), so
        // a pass-through middleware runs yet the request still routes to the
        // streaming transporter and the (non-seekable) SSE body is untouched.
        $plain = new MockClient;
        $plain->setDefaultResponse($this->response(200));

        $streaming = new MockClient;
        $streaming->setDefaultResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(200)
                ->withHeader('Content-Type', 'text/event-stream')
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(''))
        );

        $ran = false;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$ran): ResponseInterface {
                $ran = true; // observe only; do not read the streaming body

                return $next($req);
            },
        );

        $options = RequestOptions::with(
            transporter: $plain,
            streamingTransporter: $streaming,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            middleware: [$mw],
        );
        $client = new class(headers: [], baseUrl: 'http://localhost', options: $options) extends BaseClient {};

        $client->request('GET', '/', headers: ['Accept' => 'text/event-stream']);

        $this->assertTrue($ran);
        $this->assertCount(0, $plain->getRequests());
        $this->assertCount(1, $streaming->getRequests());
    }

    #[Test]
    public function testMiddlewareReachesThroughTheBetaService(): void
    {
        // The `beta` service dispatches through the client's request pipeline, so
        // both client-level and per-request middleware run for beta calls.
        $ran = [];
        $tag = function (string $name) use (&$ran): callable {
            return $this->mw(
                static function (RequestInterface $req, \Closure $next) use ($name, &$ran): ResponseInterface {
                    $ran[] = $name;

                    return $next($req);
                },
            );
        };

        $client = new Client(
            apiKey: 'test-key',
            requestOptions: ['transporter' => $this->transporter(), 'middleware' => [$tag('client')]],
        );

        $client->beta->messages->create(
            maxTokens: 1024,
            messages: [],
            model: 'claude-haiku-4-5',
            requestOptions: ['middleware' => [$tag('request')]],
        );

        $this->assertSame(['client', 'request'], $ran);
    }

    /**
     * Identity passthrough that pins the middleware callable's signature so
     * PHPStan infers `$next` inside the closures passed to it. Also documents
     * that plain callables (not just {@see Middleware} instances) are accepted.
     *
     * @param callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface $fn
     *
     * @return callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface
     */
    private function mw(callable $fn): callable
    {
        return $fn;
    }

    /**
     * @param list<Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface> $middleware
     */
    private function baseClient(
        array $middleware,
        MockClient $transporter,
        ?int $maxRetries = null,
        ?float $initialRetryDelay = null,
    ): BaseClient {
        $options = RequestOptions::with(
            transporter: $transporter,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            middleware: $middleware,
            maxRetries: $maxRetries,
            initialRetryDelay: $initialRetryDelay,
        );

        return new class(headers: [], baseUrl: 'http://localhost', options: $options) extends BaseClient {};
    }

    private function transporter(?ResponseInterface $default = null): MockClient
    {
        $transporter = new MockClient;
        $transporter->setDefaultResponse($default ?? $this->response(200));

        return $transporter;
    }

    private function response(int $status, string $body = '{}'): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($body))
        ;
    }

    private function lastRequest(MockClient $transporter): RequestInterface
    {
        $request = $transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
