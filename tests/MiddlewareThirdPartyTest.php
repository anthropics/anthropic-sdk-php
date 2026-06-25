<?php

namespace Tests;

use Anthropic\Aws\Client as AwsClient;
use Anthropic\Bedrock\BedrockMiddleware;
use Anthropic\Bedrock\Client as BedrockClient;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;
use Anthropic\Vertex\Client as VertexClient;
use Aws\Api\ApiProvider;
use Aws\Api\Parser\EventParsingIterator;
use Aws\Api\Parser\RestJsonParser;
use Aws\Api\Service;
use Aws\Api\StructureShape;
use GuzzleHttp\Psr7\NoSeekStream;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Exercises the `(request, callNext)` middleware pipeline against the
 * third-party clients (Bedrock, Vertex, the AWS gateway): middleware always
 * observes the canonical Anthropic request/response shape, while the
 * per-attempt transform beneath it produces the provider-native wire form
 * (path rewrite, body reshaping, SigV4 signing, eventstream → SSE).
 *
 * @internal
 */
#[CoversNothing]
final class MiddlewareThirdPartyTest extends TestCase
{
    #[Test]
    public function testBedrockMiddlewareSeesCanonicalRequestTransportSeesBedrockRequest(): void
    {
        // Middleware observes the canonical `/v1/messages` request (model in
        // the body, no `anthropic_version`); only the transport receives the
        // Bedrock `/model/{model}/invoke` form with the version marker and the
        // model lifted out of the body.
        $transporter = $this->transporter();
        $seenPath = null;
        $seenBody = null;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$seenPath, &$seenBody): ResponseInterface {
                $seenPath = $req->getUri()->getPath();
                $seenBody = json_decode((string) $req->getBody(), true);
                $req->getBody()->rewind();

                return $next($req);
            },
        );

        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $transporter, 'middleware' => [$mw]],
        );

        $client->messages->create(maxTokens: 1024, messages: [], model: 'anthropic.claude-haiku-4-5-v1:0');

        // Middleware: canonical shape.
        $this->assertSame('/v1/messages', $seenPath);
        $this->assertIsArray($seenBody);
        $this->assertSame('anthropic.claude-haiku-4-5-v1:0', $seenBody['model'] ?? null);
        $this->assertArrayNotHasKey('anthropic_version', $seenBody);

        // Transport: Bedrock shape.
        $sent = $this->lastRequest($transporter);
        $sentBody = json_decode((string) $sent->getBody(), true);
        $this->assertSame('/model/anthropic.claude-haiku-4-5-v1:0/invoke', $sent->getUri()->getPath());
        $this->assertIsArray($sentBody);
        $this->assertArrayNotHasKey('model', $sentBody);
        $this->assertSame('bedrock-2023-05-31', $sentBody['anthropic_version'] ?? null);
    }

    #[Test]
    public function testVertexMiddlewareSeesCanonicalRequestTransportSeesVertexRequest(): void
    {
        // Same contract on Vertex: middleware observes `/v1/messages`; the
        // transport receives the `…/{model}:rawPredict` path with the Vertex
        // `anthropic_version` and no `model` in the body.
        $transporter = $this->transporter();
        $seenPath = null;
        $seenBody = null;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$seenPath, &$seenBody): ResponseInterface {
                $seenPath = $req->getUri()->getPath();
                $seenBody = json_decode((string) $req->getBody(), true);
                $req->getBody()->rewind();

                return $next($req);
            },
        );

        $client = VertexClient::withCredentials(self::fakeCreds('fake-token'),
            location: 'us-east5',
            projectId: 'test-project',
            requestOptions: ['transporter' => $transporter, 'middleware' => [$mw]],
        );

        $client->messages->create(maxTokens: 1024, messages: [], model: 'claude-haiku-4-5');

        // Middleware: canonical shape. The Vertex base URL carries the /v1
        // segment (cross-SDK ANTHROPIC_VERTEX_BASE_URL contract), so the
        // canonical path is base-prefixed; suffix-match like real middleware.
        $this->assertIsString($seenPath);
        $this->assertStringEndsWith('/v1/messages', $seenPath);
        $this->assertIsArray($seenBody);
        $this->assertSame('claude-haiku-4-5', $seenBody['model'] ?? null);
        $this->assertArrayNotHasKey('anthropic_version', $seenBody);

        // Transport: Vertex shape.
        $sent = $this->lastRequest($transporter);
        $sentBody = json_decode((string) $sent->getBody(), true);
        $this->assertStringEndsWith('/claude-haiku-4-5:rawPredict', $sent->getUri()->getPath());
        $this->assertIsArray($sentBody);
        $this->assertArrayNotHasKey('model', $sentBody);
        $this->assertSame('vertex-2023-10-16', $sentBody['anthropic_version'] ?? null);
    }

    #[Test]
    public function testMiddlewareModelRewriteReachesTheTransportPath(): void
    {
        // Because the path/body rewrite runs beneath the chain, a middleware
        // that swaps `model` in the canonical body changes which model appears
        // in the provider URL the transport receives.
        $transporter = $this->transporter();
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next): ResponseInterface {
                $body = json_decode((string) $req->getBody(), true);
                assert(is_array($body));
                $body['model'] = 'anthropic.claude-sonnet-4-5-v1:0';
                $rewritten = $req->withBody(
                    Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode($body, JSON_THROW_ON_ERROR)),
                );

                return $next($rewritten);
            },
        );

        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $transporter, 'middleware' => [$mw]],
        );

        $client->messages->create(maxTokens: 1024, messages: [], model: 'anthropic.claude-haiku-4-5-v1:0');

        $this->assertStringContainsString(
            'anthropic.claude-sonnet-4-5-v1:0',
            $this->lastRequest($transporter)->getUri()->getPath(),
        );
    }

    #[Test]
    public function testAwsSigV4SignsMiddlewareHeadersButMiddlewareNeverSeesTheSignature(): void
    {
        // SigV4 signing runs beneath the chain, so a header a middleware adds
        // is part of the signed canonical request (it appears in
        // `SignedHeaders=`) yet the middleware itself never observes the
        // resulting `Authorization` header.
        $transporter = $this->transporter();
        $sawAuth = null;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$sawAuth): ResponseInterface {
                $sawAuth = $req->hasHeader('Authorization');

                return $next($req->withHeader('X-Test', '1'));
            },
        );

        $client = new AwsClient(
            awsAccessKey: 'AKID',
            awsSecretAccessKey: 'secret',
            awsRegion: 'us-west-2',
            workspaceId: 'default',
            requestOptions: ['transporter' => $transporter, 'middleware' => [$mw]],
        );

        $client->messages->create(maxTokens: 1024, messages: [], model: 'claude-haiku-4-5');

        $this->assertFalse($sawAuth);
        $sent = $this->lastRequest($transporter);
        $this->assertSame('1', $sent->getHeaderLine('X-Test'));
        $auth = $sent->getHeaderLine('Authorization');
        $this->assertStringStartsWith('AWS4-HMAC-SHA256 ', $auth);
        $this->assertMatchesRegularExpression('/SignedHeaders=[^,]*\bx-test\b/', $auth);
    }

    #[Test]
    public function testBedrockEventstreamResponseReachesMiddlewareAsSseAndDecodesToEvents(): void
    {
        // The transport returns a raw AWS eventstream body; the per-attempt
        // transform translates it to SSE *before* the chain unwinds, so the
        // middleware observes `text/event-stream` and the SDK's returned
        // stream yields decoded message events.
        $body = $this->eventstreamChunk($this->messageStartJson())
            .$this->eventstreamChunk('{"type":"message_stop"}');
        $transporter = $this->transporter($this->eventstreamResponse($body));

        $seenContentType = null;
        $mw = $this->mw(
            static function (RequestInterface $req, \Closure $next) use (&$seenContentType): ResponseInterface {
                $rsp = $next($req);
                $seenContentType = $rsp->getHeaderLine('Content-Type');

                return $rsp;
            },
        );

        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: [
                'transporter' => $transporter,
                'streamingTransporter' => $transporter,
                'middleware' => [$mw],
            ],
        );

        $stream = $client->messages->createStream(maxTokens: 1024, messages: [], model: 'anthropic.claude-haiku-4-5-v1:0');

        $this->assertSame('text/event-stream', $seenContentType);

        $events = [];
        foreach ($stream as $event) {
            $events[] = $event;
        }
        $this->assertCount(2, $events);
        $this->assertInstanceOf(RawMessageStartEvent::class, $events[0]);
        $this->assertInstanceOf(RawMessageStopEvent::class, $events[1]);
    }

    #[Test]
    public function testBedrockEventstreamExceptionFrameSurfacesAsApiException(): void
    {
        // An eventstream `exception` frame mid-stream surfaces as an
        // APIException during iteration, after the events that preceded it.
        $body = $this->eventstreamChunk($this->messageStartJson())
            .$this->eventstreamException('internalServerException', '{"message":"boom"}');
        $transporter = $this->transporter($this->eventstreamResponse($body));

        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: [
                'transporter' => $transporter,
                'streamingTransporter' => $transporter,
                'middleware' => [$this->mw(static fn (RequestInterface $req, \Closure $next): ResponseInterface => $next($req))],
            ],
        );

        $stream = $client->messages->createStream(maxTokens: 1024, messages: [], model: 'anthropic.claude-haiku-4-5-v1:0');

        /** @var list<object> $events */
        $events = [];
        try {
            foreach ($stream as $event) {
                $events[] = $event;
            }
            $this->fail('expected APIException');
        } catch (APIException) {
            // expected
        }

        $this->assertCount(1, $events);
        $this->assertInstanceOf(RawMessageStartEvent::class, $events[0]);
    }

    #[Test]
    public function testBedrockEventstreamEagerEofBodyYieldsEveryFrame(): void
    {
        $bytes = $this->eventstreamChunk($this->messageStartJson())
            .$this->eventstreamChunk('{"type":"message_delta","delta":{},"usage":{}}')
            .$this->eventstreamChunk('{"type":"message_stop"}');

        // Negative: the raw AWS decoder over an eager-EOF body drops the last
        // frame because valid() = !eof() goes false right after parsing it.
        $provider = ApiProvider::defaultProvider();
        $service = new Service(ApiProvider::resolve($provider, 'api', 'bedrock-runtime', '2023-09-30'), $provider);
        $shape = $service->getShapeMap()->resolve(['shape' => 'ResponseStream']);
        assert($shape instanceof StructureShape);
        $raw = new EventParsingIterator(new NoSeekStream($this->eagerEofStream($bytes)), $shape, new RestJsonParser($service));
        $this->assertCount(2, iterator_to_array($raw, false));

        // Positive: through BedrockMiddleware (which wraps the body in
        // ReadFillStream), all three frames reach the SDK stream.
        $transporter = $this->transporter($this->eventstreamResponse($bytes, eagerEof: true));
        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $transporter, 'streamingTransporter' => $transporter],
        );

        $events = [];
        foreach ($client->messages->createStream(maxTokens: 1, messages: [], model: 'm:0') as $event) {
            $events[] = $event;
        }

        $this->assertCount(3, $events);
        $this->assertInstanceOf(RawMessageStartEvent::class, $events[0]);
        $this->assertInstanceOf(RawMessageDeltaEvent::class, $events[1]);
        $this->assertInstanceOf(RawMessageStopEvent::class, $events[2]);
    }

    #[Test]
    public function testBedrockEventstreamReadReturnsOneFramePerCall(): void
    {
        $frame1 = $this->eventstreamChunk($this->messageStartJson());
        $frame2 = $this->eventstreamChunk('{"type":"message_delta","delta":{},"usage":{}}');
        $frame3 = $this->eventstreamChunk('{"type":"message_stop"}');
        $boundary1 = strlen($frame1);
        $boundary2 = strlen($frame1.$frame2);

        $highWater = 0;
        $source = $this->eagerEofStream($frame1.$frame2.$frame3, $highWater);
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/vnd.amazon.eventstream')
            ->withBody($source);

        $mw = new BedrockMiddleware(Psr17FactoryDiscovery::findStreamFactory(), static fn (RequestInterface $r): RequestInterface => $r);
        $rewritten = $mw->handle(
            Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', 'https://h/x'),
            static fn (RequestInterface $req): ResponseInterface => $response,
        );
        $body = $rewritten->getBody();

        $sse1 = $body->read(8192);
        $this->assertSame("event: message_start\ndata: {$this->messageStartJson()}\n\n", $sse1);
        // The decoder peeks one byte past each frame to check for EOF; allow that, but no further.
        $this->assertLessThanOrEqual($boundary1 + 1, $highWater);

        $sse2 = $body->read(8192);
        $this->assertStringStartsWith("event: message_delta\n", $sse2);
        $this->assertLessThanOrEqual($boundary2 + 1, $highWater);

        $this->assertStringStartsWith("event: message_stop\n", $body->read(8192));
        $this->assertSame('', $body->read(8192));
        $this->assertTrue($body->eof());
    }

    #[Test]
    public function testBedrockStreamCloseClosesTheNetworkBody(): void
    {
        $bytes = $this->eventstreamChunk($this->messageStartJson())
            .$this->eventstreamChunk('{"type":"message_delta","delta":{},"usage":{}}')
            .$this->eventstreamChunk('{"type":"message_stop"}');

        $source = $this->eagerEofStream($bytes);
        $response = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/vnd.amazon.eventstream')
            ->withBody($source);

        $mw = new BedrockMiddleware(Psr17FactoryDiscovery::findStreamFactory(), static fn (RequestInterface $r): RequestInterface => $r);
        $rewritten = $mw->handle(
            Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', 'https://h/x'),
            static fn (RequestInterface $req): ResponseInterface => $response,
        );
        $body = $rewritten->getBody();

        $this->assertStringStartsWith("event: message_start\n", $body->read(8192));
        $this->assertNull($source->getMetadata('closed'));

        $body->close();
        $this->assertTrue($source->getMetadata('closed'));
    }

    #[Test]
    public function testBedrockCountTokensWrapsBodyAndRoutesToCountTokensPath(): void
    {
        $transporter = $this->transporter($this->response(200, '{"inputTokens":42}'));
        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $transporter],
        );

        $result = $client->messages->countTokens(
            model: 'anthropic.claude-3-5-sonnet-20241022-v2:0',
            messages: [['role' => 'user', 'content' => 'hi']],
        );

        $sent = $this->lastRequest($transporter);
        $this->assertSame('/model/anthropic.claude-3-5-sonnet-20241022-v2:0/count-tokens', $sent->getUri()->getPath());

        $body = json_decode((string) $sent->getBody(), true);
        $this->assertIsArray($body);
        $this->assertIsArray($body['input'] ?? null);
        $this->assertIsArray($body['input']['invokeModel'] ?? null);
        $this->assertIsString($body['input']['invokeModel']['body'] ?? null);
        $inner = base64_decode($body['input']['invokeModel']['body'], true);
        $this->assertIsString($inner);
        $decoded = json_decode($inner, true);
        $this->assertIsArray($decoded);
        $this->assertSame('bedrock-2023-05-31', $decoded['anthropic_version'] ?? null);
        $this->assertSame(1024, $decoded['max_tokens'] ?? null);
        $this->assertSame([['role' => 'user', 'content' => 'hi']], $decoded['messages'] ?? null);
        $this->assertArrayNotHasKey('model', $decoded);

        $this->assertSame(42, $result->inputTokens);
    }

    #[Test]
    public function testVertexCountTokensRoutesToCountTokensPathAndKeepsModel(): void
    {
        $transporter = $this->transporter($this->response(200, '{"input_tokens":7}'));
        $client = VertexClient::withCredentials(self::fakeCreds('fake-token'),
            location: 'us-east5',
            projectId: 'test-project',
            requestOptions: ['transporter' => $transporter],
        );

        $client->messages->countTokens(
            model: 'claude-3-7-sonnet@20250219',
            messages: [['role' => 'user', 'content' => 'hi']],
        );

        $sent = $this->lastRequest($transporter);
        $this->assertSame(
            '/v1/projects/test-project/locations/us-east5/publishers/anthropic/models/count-tokens:rawPredict',
            $sent->getUri()->getPath(),
        );
        $body = json_decode((string) $sent->getBody(), true);
        $this->assertIsArray($body);
        $this->assertSame('claude-3-7-sonnet@20250219', $body['model'] ?? null);
        $this->assertSame('vertex-2023-10-16', $body['anthropic_version'] ?? null);
    }

    #[Test]
    public function testVertexBetaMessagesCreateRoutesToRawPredictAndSetsAnthropicBetaHeader(): void
    {
        $transporter = $this->transporter();
        $client = VertexClient::withCredentials(self::fakeCreds('fake-token'),
            location: 'us-east5',
            projectId: 'test-project',
            requestOptions: ['transporter' => $transporter],
        );

        $client->beta->messages->create(
            maxTokens: 1024,
            messages: [],
            model: 'claude-3-7-sonnet@20250219',
            betas: ['foo-2025-01-01'],
        );

        $sent = $this->lastRequest($transporter);
        $this->assertSame(
            '/v1/projects/test-project/locations/us-east5/publishers/anthropic/models/claude-3-7-sonnet@20250219:rawPredict',
            $sent->getUri()->getPath(),
        );
        $this->assertSame('', $sent->getUri()->getQuery());
        $this->assertSame('foo-2025-01-01', $sent->getHeaderLine('anthropic-beta'));
        $body = json_decode((string) $sent->getBody(), true);
        $this->assertIsArray($body);
        $this->assertSame('vertex-2023-10-16', $body['anthropic_version'] ?? null);
        $this->assertArrayNotHasKey('model', $body);
    }

    #[Test]
    public function testRewriteDropsBetaQueryParamButKeepsOthers(): void
    {
        $mw = $this->mw(
            static fn (RequestInterface $req, \Closure $next): ResponseInterface => $next(
                $req->withUri($req->getUri()->withQuery('beta=true&trace=abc')),
            ),
        );

        $bedrockT = $this->transporter();
        $bedrock = BedrockClient::withApiKey('test-key', region: 'us-east-1', requestOptions: ['transporter' => $bedrockT, 'middleware' => [$mw]]);
        $bedrock->messages->create(maxTokens: 1, messages: [], model: 'm:0');
        $this->assertSame('trace=abc', $this->lastRequest($bedrockT)->getUri()->getQuery());

        $vertexT = $this->transporter();
        $vertex = VertexClient::withCredentials(self::fakeCreds('t'), location: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $vertexT, 'middleware' => [$mw]]);
        $vertex->messages->create(maxTokens: 1, messages: [], model: 'm');
        $this->assertSame('trace=abc', $this->lastRequest($vertexT)->getUri()->getQuery());
    }

    #[Test]
    public function testBedrockBetaHeaderMovesIntoBodyAndIsRemovedFromRequest(): void
    {
        $transporter = $this->transporter();
        $client = BedrockClient::withApiKey('test-key', region: 'us-east-1', requestOptions: ['transporter' => $transporter]);

        $client->messages->create(
            maxTokens: 1,
            messages: [],
            model: 'm:0',
            requestOptions: ['extraHeaders' => ['anthropic-beta' => 'a, b']],
        );

        $sent = $this->lastRequest($transporter);
        $this->assertSame('', $sent->getHeaderLine('anthropic-beta'));
        $this->assertSame('application/json', $sent->getHeaderLine('X-Amzn-Bedrock-Accept'));
        $body = json_decode((string) $sent->getBody(), true);
        $this->assertIsArray($body);
        $this->assertSame(['a', 'b'], $body['anthropic_beta'] ?? null);
    }

    #[Test]
    public function testBedrockStripsFirstPartyHeadersEvenWhenCallerSetsThem(): void
    {
        $transporter = $this->transporter();
        $client = BedrockClient::withApiKey('test-key', region: 'us-east-1', requestOptions: ['transporter' => $transporter]);

        $client->messages->create(
            maxTokens: 1,
            messages: [],
            model: 'm:0',
            userProfileID: 'upid-123',
            requestOptions: ['extraHeaders' => ['anthropic-workspace-id' => 'ws-456']],
        );

        $sent = $this->lastRequest($transporter);
        foreach (['anthropic-version', 'anthropic-beta', 'anthropic-user-profile-id', 'anthropic-workspace-id'] as $h) {
            $this->assertFalse($sent->hasHeader($h), "expected {$h} to be stripped before reaching Bedrock");
        }
    }

    #[Test]
    public function testVertexStripsFirstPartyHeadersEvenWhenCallerSetsThem(): void
    {
        $transporter = $this->transporter();
        $client = VertexClient::withCredentials(self::fakeCreds('fake-token'),
            location: 'us-east5',
            projectId: 'test-project',
            requestOptions: ['transporter' => $transporter],
        );

        $client->messages->create(
            maxTokens: 1,
            messages: [],
            model: 'm@v',
            userProfileID: 'upid-123',
            requestOptions: ['extraHeaders' => ['anthropic-workspace-id' => 'ws-456']],
        );

        $sent = $this->lastRequest($transporter);
        foreach (['anthropic-version', 'anthropic-user-profile-id', 'anthropic-workspace-id'] as $h) {
            $this->assertFalse($sent->hasHeader($h), "expected {$h} to be stripped before reaching Vertex");
        }
        $this->assertSame('', $sent->getHeaderLine('anthropic-beta'));
    }

    #[Test]
    public function testBedrockApiKeyAuthDoesNotOverwriteCallerAuthorization(): void
    {
        $transporter = $this->transporter();
        $client = BedrockClient::withApiKey('default-key', region: 'us-east-1', requestOptions: ['transporter' => $transporter]);

        $client->messages->create(
            maxTokens: 1,
            messages: [],
            model: 'm:0',
            requestOptions: ['extraHeaders' => ['Authorization' => 'Bearer caller-wins']],
        );

        $this->assertSame('Bearer caller-wins', $this->lastRequest($transporter)->getHeaderLine('Authorization'));
    }

    #[Test]
    public function testBedrockBaseUrlPathPrefixIsPreserved(): void
    {
        $transporter = $this->transporter();
        $client = BedrockClient::withApiKey('test-key', region: 'us-east-1', baseUrl: 'https://gw.example/proxy', requestOptions: ['transporter' => $transporter]);

        $client->messages->create(maxTokens: 1, messages: [], model: 'm:0');

        $this->assertSame('/proxy/model/m:0/invoke', $this->lastRequest($transporter)->getUri()->getPath());
    }

    #[Test]
    public function testVertexBaseUrlPathPrefixIsPreservedAndModelAtSignIsLiteral(): void
    {
        $transporter = $this->transporter();
        $client = VertexClient::withCredentials(self::fakeCreds('t'), location: 'us-east5', projectId: 'p', baseUrl: 'https://gw.example/proxy', requestOptions: ['transporter' => $transporter]);

        $client->messages->create(maxTokens: 1, messages: [], model: 'claude-3-7-sonnet@20250219');

        $this->assertSame(
            '/proxy/projects/p/locations/us-east5/publishers/anthropic/models/claude-3-7-sonnet@20250219:rawPredict',
            $this->lastRequest($transporter)->getUri()->getPath(),
        );
    }

    #[Test]
    public function testVertexDoesNotOverwriteCallerAuthorization(): void
    {
        $transporter = $this->transporter();
        $client = VertexClient::withCredentials(self::fakeCreds('default-token'), location: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter]);

        $client->messages->create(
            maxTokens: 1,
            messages: [],
            model: 'm',
            requestOptions: ['extraHeaders' => ['Authorization' => 'Bearer caller-wins']],
        );

        $this->assertSame('Bearer caller-wins', $this->lastRequest($transporter)->getHeaderLine('Authorization'));
    }

    #[Test]
    public function testVertexStreamRoutesToStreamRawPredictAndKeepsStreamInBody(): void
    {
        $sse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'text/event-stream')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(''));
        $transporter = $this->transporter($sse);
        $client = VertexClient::withCredentials(self::fakeCreds('t'), location: 'us-east5', projectId: 'p', requestOptions: ['transporter' => $transporter, 'streamingTransporter' => $transporter]);

        $client->messages->createStream(maxTokens: 1, messages: [], model: 'm');

        $sent = $this->lastRequest($transporter);
        $this->assertStringEndsWith('/m:streamRawPredict', $sent->getUri()->getPath());
        $body = json_decode((string) $sent->getBody(), true);
        $this->assertIsArray($body);
        $this->assertTrue($body['stream'] ?? null);
    }

    #[Test]
    public function testBedrockStreamRoutesToInvokeWithResponseStreamAndDropsStreamFromBody(): void
    {
        $transporter = $this->transporter($this->eventstreamResponse($this->eventstreamChunk('{"type":"message_stop"}')));
        $client = BedrockClient::withApiKey('test-key', region: 'us-east-1', requestOptions: ['transporter' => $transporter, 'streamingTransporter' => $transporter]);

        $client->messages->createStream(maxTokens: 1, messages: [], model: 'm:0');

        $sent = $this->lastRequest($transporter);
        $this->assertSame('/model/m:0/invoke-with-response-stream', $sent->getUri()->getPath());
        $body = json_decode((string) $sent->getBody(), true);
        $this->assertIsArray($body);
        $this->assertArrayNotHasKey('stream', $body);
    }

    #[Test]
    public function testVertexBatchesThrowsNotSupported(): void
    {
        $client = VertexClient::withCredentials(self::fakeCreds('fake-token'),
            location: 'us-east5',
            projectId: 'test-project',
            requestOptions: ['transporter' => $this->transporter()],
        );

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessageMatches('/\/v1\/messages\/batches.*not available via Vertex.*Anthropic\\\\Client/i');
        $client->messages->batches->create(requests: []);
    }

    #[Test]
    public function testVertexModelsThrowsNotSupported(): void
    {
        $client = VertexClient::withCredentials(self::fakeCreds('fake-token'),
            location: 'us-east5',
            projectId: 'test-project',
            requestOptions: ['transporter' => $this->transporter()],
        );

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessageMatches('/\/v1\/models.*not available via Vertex.*Anthropic\\\\Client/i');
        $client->models->list();
    }

    #[Test]
    public function testBedrockBatchesThrowsNotSupported(): void
    {
        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter()],
        );

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessageMatches('/\/v1\/messages\/batches.*not available via Bedrock.*Anthropic\\\\Client/i');
        $client->messages->batches->create(requests: []);
    }

    #[Test]
    public function testBedrockModelsThrowsNotSupported(): void
    {
        $client = BedrockClient::withApiKey(
            apiKey: 'test-key',
            region: 'us-east-1',
            requestOptions: ['transporter' => $this->transporter()],
        );

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessageMatches('/\/v1\/models.*not available via Bedrock.*Anthropic\\\\Client/i');
        $client->models->list();
    }

    #[Test]
    public function testBedrockNonV1PathPassesThroughUnchanged(): void
    {
        $mw = new BedrockMiddleware(Psr17FactoryDiscovery::findStreamFactory(), static fn (RequestInterface $r): RequestInterface => $r);
        $request = Psr17FactoryDiscovery::findRequestFactory()->createRequest('GET', 'https://h/health');

        $seen = null;
        $mw->handle($request, function (RequestInterface $req) use (&$seen): ResponseInterface {
            $seen = $req;

            return $this->response(200);
        });

        $this->assertSame('/health', $seen?->getUri()->getPath());
    }

    /**
     * Identity passthrough that pins the middleware callable's signature so
     * PHPStan infers `$next` inside the closures passed to it.
     *
     * @param callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface $fn
     *
     * @return callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface
     */
    private function mw(callable $fn): callable
    {
        return $fn;
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

    private function eventstreamResponse(string $body, bool $eagerEof = false): ResponseInterface
    {
        $stream = $eagerEof ? $this->eagerEofStream($body) : Psr17FactoryDiscovery::findStreamFactory()->createStream($body);

        return Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse(200)
            ->withHeader('Content-Type', 'application/vnd.amazon.eventstream')
            ->withBody($stream)
        ;
    }

    /**
     * A read-only body whose `eof()` goes true as soon as the last byte is
     * consumed (network-stream semantics, vs php://temp which only sets feof
     * after a read past the end). Records the highest byte offset read into
     * `$highWater`; whether `close()` was called is exposed via
     * `getMetadata('closed')`.
     */
    private function eagerEofStream(string $bytes, int &$highWater = 0): StreamInterface
    {
        return new class($bytes, $highWater) implements StreamInterface {
            private int $pos = 0;
            private bool $closed = false;

            public function __construct(private string $bytes, private int &$highWater) {}

            public function read($length): string
            {
                $out = substr($this->bytes, $this->pos, $length);
                $this->pos += strlen($out);
                $this->highWater = max($this->highWater, $this->pos);

                return $out;
            }

            public function eof(): bool
            {
                return $this->pos >= strlen($this->bytes);
            }

            public function isReadable(): bool
            {
                return true;
            }

            public function isSeekable(): bool
            {
                return false;
            }

            public function isWritable(): bool
            {
                return false;
            }

            public function getSize(): ?int
            {
                return null;
            }

            public function tell(): int
            {
                return $this->pos;
            }

            public function close(): void
            {
                $this->closed = true;
            }

            public function detach()
            {
                return null;
            }

            public function seek($offset, $whence = SEEK_SET): void
            {
                throw new \RuntimeException('not seekable');
            }

            public function rewind(): void
            {
                throw new \RuntimeException('not seekable');
            }

            public function write($string): int
            {
                throw new \RuntimeException('not writable');
            }

            public function getContents(): string
            {
                return $this->read(strlen($this->bytes));
            }

            public function getMetadata($key = null)
            {
                $meta = ['closed' => $this->closed ?: null];

                return null === $key ? $meta : ($meta[$key] ?? null);
            }

            public function __toString(): string
            {
                return $this->bytes;
            }
        };
    }

    private function lastRequest(MockClient $transporter): RequestInterface
    {
        $request = $transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }

    private static function fakeCreds(string $token): \Google\Auth\FetchAuthTokenInterface
    {
        return new class($token) implements \Google\Auth\FetchAuthTokenInterface {
            public function __construct(private string $token) {}

            public function fetchAuthToken(?callable $httpHandler = null): array
            {
                return ['access_token' => $this->token];
            }

            public function getCacheKey(): ?string
            {
                return null;
            }

            public function getLastReceivedToken(): ?array
            {
                return null;
            }
        };
    }

    private function messageStartJson(): string
    {
        return json_encode([
            'type' => 'message_start',
            'message' => [
                'id' => 'msg_1',
                'type' => 'message',
                'role' => 'assistant',
                'content' => [],
                'model' => 'anthropic.claude-haiku-4-5-v1:0',
                'stop_reason' => null,
                'stop_sequence' => null,
                'usage' => ['input_tokens' => 1, 'output_tokens' => 1],
            ],
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * Encode one AWS eventstream `chunk` event frame carrying the given JSON
     * as the `bytes` blob of a Bedrock `PayloadPart`.
     */
    private function eventstreamChunk(string $innerJson): string
    {
        $payload = json_encode(['bytes' => base64_encode($innerJson)], JSON_THROW_ON_ERROR);

        return $this->eventstreamFrame(
            [':message-type' => 'event', ':event-type' => 'chunk', ':content-type' => 'application/json'],
            $payload,
        );
    }

    /**
     * Encode one AWS eventstream `exception` frame.
     */
    private function eventstreamException(string $exceptionType, string $payload): string
    {
        return $this->eventstreamFrame(
            [':message-type' => 'exception', ':exception-type' => $exceptionType, ':content-type' => 'application/json'],
            $payload,
        );
    }

    /**
     * Hand-encode one `application/vnd.amazon.eventstream` frame: a 12-byte
     * prelude (total length, headers length, prelude CRC), string-typed
     * headers, the payload, and a trailing message CRC.
     *
     * @param array<string,string> $headers
     */
    private function eventstreamFrame(array $headers, string $payload): string
    {
        $headerBytes = '';
        foreach ($headers as $name => $value) {
            $headerBytes .= chr(strlen($name)).$name.chr(7).pack('n', strlen($value)).$value;
        }

        $total = 12 + strlen($headerBytes) + strlen($payload) + 4;
        $prelude = pack('NN', $total, strlen($headerBytes));
        $message = $prelude.pack('N', crc32($prelude)).$headerBytes.$payload;

        return $message.pack('N', crc32($message));
    }
}
