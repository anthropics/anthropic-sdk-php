<?php

namespace Tests\Core;

use Anthropic\Client;
use Anthropic\Core\BaseClient;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIStatusException;
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
 * Exercises the `(request, callNext)` middleware pipeline: modifying the
 * request (add / replace / remove headers), observing the response, custom
 * programmatic retry, short-circuiting, ordering, the class form, and the
 * call-level `withMiddleware()` deriver.
 *
 * @internal
 */
#[CoversNothing]
final class MiddlewareTest extends TestCase
{
    #[Test]
    public function testAddsHeader(): void
    {
        $transporter = $this->transporter();
        $mw = $this->mw(
            static fn (RequestInterface $req, \Closure $next): ResponseInterface => $next(
                $req->withHeader('X-Trace-Id', 'trace-123'),
            ),
        );

        $this->baseClient([$mw], $transporter)->request('GET', '/');

        $this->assertSame('trace-123', $this->lastRequest($transporter)->getHeaderLine('X-Trace-Id'));
    }

    #[Test]
    public function testReplacesHeader(): void
    {
        $transporter = $this->transporter();
        $mw = $this->mw(
            static fn (RequestInterface $req, \Closure $next): ResponseInterface => $next(
                $req->withHeader('X-Demo', 'new'),
            ),
        );

        $this->baseClient([$mw], $transporter)->request('GET', '/', headers: ['X-Demo' => 'old']);

        // withHeader replaces rather than appends — exactly one value remains.
        $this->assertSame(['new'], $this->lastRequest($transporter)->getHeader('X-Demo'));
    }

    #[Test]
    public function testRemovesHeader(): void
    {
        $transporter = $this->transporter();
        $mw = $this->mw(
            static fn (RequestInterface $req, \Closure $next): ResponseInterface => $next(
                $req->withoutHeader('X-Demo'),
            ),
        );

        $this->baseClient([$mw], $transporter)->request('GET', '/', headers: ['X-Demo' => 'remove-me']);

        $this->assertFalse($this->lastRequest($transporter)->hasHeader('X-Demo'));
    }

    #[Test]
    public function testObservesResponseForNonSuccessWithoutRaisingInsideChain(): void
    {
        // callNext returns the response for *every* HTTP status; only after the
        // chain unwinds does the SDK raise for an un-retryable 4xx.
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
    public function testMiddlewareCanReadResponseBodyWithoutBreakingParse(): void
    {
        // A middleware that reads the response body (e.g. for logging) consumes
        // the stream; the SDK must still be able to decode it afterwards.
        $transporter = $this->transporter($this->response(200, '{"ok":true}'));
        $sawBody = null;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$sawBody): ResponseInterface {
                $rsp = $next($req);
                $sawBody = (string) $rsp->getBody(); // consumes the stream

                return $rsp;
            },
        );

        $parsed = $this->baseClient([$mw], $transporter)
            ->request('GET', '/', convert: 'mixed')
            ->parse()
        ;

        $this->assertSame('{"ok":true}', $sawBody);
        // decodeContent rewinds the seekable body, so parsing still succeeds.
        $this->assertSame(['ok' => true], $parsed);
    }

    #[Test]
    public function testBodyIsRewoundBetweenCallNextInvocations(): void
    {
        // A middleware that calls callNext twice (custom retry) must re-send the
        // full request body each time — the seekable body is rewound per send.
        $bodies = [];
        $record = static function (string $body) use (&$bodies): void {
            $bodies[] = $body;
        };
        $response = $this->response(200);
        $transporter = new class($record, $response) implements ClientInterface {
            public function __construct(
                private \Closure $record,
                private ResponseInterface $response,
            ) {}

            public function sendRequest(RequestInterface $request): ResponseInterface
            {
                ($this->record)((string) $request->getBody());

                return $this->response;
            }
        };

        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next): ResponseInterface {
                $next($req);

                return $next($req);
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

        $this->assertSame(['{"x":1}', '{"x":1}'], $bodies);
    }

    #[Test]
    public function testCustomProgrammaticRetry(): void
    {
        // A user-defined retry that keys off response *content* (not an
        // HTTP status the SDK would retry on), calling callNext again.
        $transporter = new MockClient;
        $transporter->addResponse($this->response(200, '{"should_retry":true}'));
        $transporter->addResponse($this->response(200, '{"ok":true}'));

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

        $this->baseClient([$mw], $transporter)->request('GET', '/');

        $this->assertCount(2, $transporter->getRequests());
        $this->assertSame('{"ok":true}', $finalBody);
    }

    #[Test]
    public function testClientExceptionFromMiddlewareBecomesConnectionError(): void
    {
        // A PSR-18 transport exception thrown by middleware is treated like a
        // connection failure: surfaced as APIConnectionException (original kept
        // as `previous`), and not retried by the default policy.
        $transporter = $this->transporter();
        $boom = new class('kaboom') extends \RuntimeException implements ClientExceptionInterface {};
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use ($boom): ResponseInterface {
                throw $boom;
            },
        );

        try {
            $this->baseClient([$mw], $transporter)->request('GET', '/');
            $this->fail('expected APIConnectionException');
        } catch (APIConnectionException $e) {
            $this->assertSame($boom, $e->getPrevious());
        }

        // Threw before reaching the transport, and a null response is not retried.
        $this->assertCount(0, $transporter->getRequests());
    }

    #[Test]
    public function testNonTransportExceptionFromMiddlewarePropagates(): void
    {
        // Any non-PSR-18 exception propagates unchanged — not swallowed, not wrapped.
        $transporter = $this->transporter();
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next): ResponseInterface {
                throw new \RuntimeException('middleware boom');
            },
        );

        try {
            $this->baseClient([$mw], $transporter)->request('GET', '/');
            $this->fail('expected RuntimeException');
        } catch (\RuntimeException $e) {
            $this->assertSame('middleware boom', $e->getMessage());
        }

        $this->assertCount(0, $transporter->getRequests());
    }

    #[Test]
    public function testMiddlewareRunsOnStreamingRequestsWithoutDisruptingRouting(): void
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
    public function testShortCircuitSkipsTransport(): void
    {
        // Returning a response without calling callNext (e.g. a cache hit)
        // means the transport is never reached.
        $transporter = $this->transporter();
        $cached = $this->response(200, '{"cached":true}');
        $mw = $this->mw(
            static fn (RequestInterface $req, \Closure $next): ResponseInterface => $cached,
        );

        $this->baseClient([$mw], $transporter)->request('GET', '/');

        $this->assertCount(0, $transporter->getRequests());
    }

    #[Test]
    public function testRunsOutermostFirst(): void
    {
        $transporter = $this->transporter();
        $order = [];
        $outer = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$order): ResponseInterface {
                $order[] = 'outer-before';
                $rsp = $next($req);
                $order[] = 'outer-after';

                return $rsp;
            },
        );
        $inner = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$order): ResponseInterface {
                $order[] = 'inner-before';
                $rsp = $next($req);
                $order[] = 'inner-after';

                return $rsp;
            },
        );

        $this->baseClient([$outer, $inner], $transporter)->request('GET', '/');

        $this->assertSame(
            ['outer-before', 'inner-before', 'inner-after', 'outer-after'],
            $order,
        );
    }

    #[Test]
    public function testTransformRequestRunsInsideInnermostCallNext(): void
    {
        // With two middleware, the per-attempt request signing / URL-rewriting
        // done in transformRequest() must run *inside* the innermost callNext:
        // both middleware see the canonical (unsigned) request, and only the
        // transport receives the signed one.
        $transporter = $this->transporter();
        $order = [];
        $outerSawSigned = null;
        $innerSawSigned = null;

        $outer = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$order, &$outerSawSigned): ResponseInterface {
                $order[] = 'outer-before';
                $outerSawSigned = $req->hasHeader('X-Signed');
                $rsp = $next($req);
                $order[] = 'outer-after';

                return $rsp;
            },
        );
        $inner = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$order, &$innerSawSigned): ResponseInterface {
                $order[] = 'inner-before';
                $innerSawSigned = $req->hasHeader('X-Signed');
                $rsp = $next($req);
                $order[] = 'inner-after';

                return $rsp;
            },
        );

        $options = RequestOptions::with(
            transporter: $transporter,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            middleware: [$outer, $inner],
        );

        // A client whose transformRequest() signs the request (as Bedrock/Vertex
        // do, per attempt) and records when it runs relative to the middleware.
        $record = static function (string $marker) use (&$order): void {
            $order[] = $marker;
        };
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

        $client->request('GET', '/');

        // Both middleware saw the canonical request — signing happens deeper.
        $this->assertFalse($outerSawSigned);
        $this->assertFalse($innerSawSigned);
        // transform runs once, between the innermost middleware's before/after.
        $this->assertSame(
            ['outer-before', 'inner-before', 'transform', 'inner-after', 'outer-after'],
            $order,
        );
        // The transport receives the signed request.
        $this->assertSame('1', $this->lastRequest($transporter)->getHeaderLine('X-Signed'));
    }

    #[Test]
    public function testClassFormMiddleware(): void
    {
        $transporter = $this->transporter();
        $mw = new class() implements Middleware {
            public bool $ran = false;

            public function handle(RequestInterface $request, \Closure $callNext): ResponseInterface
            {
                $this->ran = true;

                return $callNext($request->withHeader('X-Class', 'yes'));
            }
        };

        $this->baseClient([$mw], $transporter)->request('GET', '/');

        $this->assertTrue($mw->ran);
        $this->assertSame('yes', $this->lastRequest($transporter)->getHeaderLine('X-Class'));
    }

    #[Test]
    public function testConstructorMiddlewareRunsOnEveryRequest(): void
    {
        $transporter = $this->transporter();
        $count = 0;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$count): ResponseInterface {
                ++$count;

                return $next($req);
            },
        );

        $client = new Client(
            apiKey: 'test-key',
            requestOptions: ['transporter' => $transporter],
            middleware: [$mw],
        );

        $client->request('GET', '/');
        $client->request('GET', '/');

        $this->assertSame(2, $count);
        $this->assertSame([$mw], $client->middleware());
    }

    #[Test]
    public function testWithMiddlewareAppendsAndDoesNotMutateOriginal(): void
    {
        $transporter = $this->transporter();
        $order = [];
        $base = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$order): ResponseInterface {
                $order[] = 'base';

                return $next($req);
            },
        );
        $extra = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$order): ResponseInterface {
                $order[] = 'extra';

                return $next($req);
            },
        );

        $client = new Client(
            apiKey: 'test-key',
            requestOptions: ['transporter' => $transporter],
            middleware: [$base],
        );
        $derived = $client->withMiddleware($extra);

        $derived->request('GET', '/');

        // Appended middleware runs *inside* the client's own.
        $this->assertSame(['base', 'extra'], $order);
        // Original is untouched; the derived copy carries both.
        $this->assertSame([$base], $client->middleware());
        $this->assertCount(2, $derived->middleware());
        // The clone rewires its service tree to dispatch through itself.
        $this->assertNotSame($client->messages, $derived->messages);
    }

    #[Test]
    public function testMiddlewareAppliesThroughBetaService(): void
    {
        // The `beta` service dispatches through the client's request pipeline,
        // so client-level middleware runs for beta calls too.
        $transporter = $this->transporter();
        $ran = false;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$ran): ResponseInterface {
                $ran = true;

                return $next($req);
            },
        );

        $client = new Client(
            apiKey: 'test-key',
            requestOptions: ['transporter' => $transporter],
            middleware: [$mw],
        );

        $client->beta->messages->create(maxTokens: 1024, messages: [], model: 'claude-haiku-4-5');

        $this->assertTrue($ran);
    }

    #[Test]
    public function testPerRequestMiddlewareAppliesThroughBetaService(): void
    {
        $transporter = $this->transporter();
        $ran = false;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$ran): ResponseInterface {
                $ran = true;

                return $next($req);
            },
        );

        $client = new Client(
            apiKey: 'test-key',
            requestOptions: ['transporter' => $transporter],
        );

        $client->beta->messages->create(
            maxTokens: 1024,
            messages: [],
            model: 'claude-haiku-4-5',
            requestOptions: ['middleware' => [$mw]],
        );

        $this->assertTrue($ran);
    }

    #[Test]
    public function testWithMiddlewareAppliesThroughBetaService(): void
    {
        // The clone rewires the whole service tree (including `beta`) to the
        // derived client, so appended middleware runs on beta calls; the
        // original client's beta service is unaffected.
        $transporter = $this->transporter();
        $ran = false;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$ran): ResponseInterface {
                $ran = true;

                return $next($req);
            },
        );

        $client = new Client(
            apiKey: 'test-key',
            requestOptions: ['transporter' => $transporter],
        );
        $derived = $client->withMiddleware($mw);

        $this->assertNotSame($client->beta, $derived->beta);

        $derived->beta->messages->create(maxTokens: 1024, messages: [], model: 'claude-haiku-4-5');

        $this->assertTrue($ran);
        // Original client's beta still has no middleware.
        $this->assertSame([], $client->middleware());
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
    private function baseClient(array $middleware, MockClient $transporter): BaseClient
    {
        $options = RequestOptions::with(
            transporter: $transporter,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
            middleware: $middleware,
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
