<?php

declare(strict_types=1);

namespace Anthropic\Bedrock;

use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\RequestTransformer;
use Anthropic\Core\Util;
use Anthropic\Middleware;
use Aws\Api\ApiProvider;
use Aws\Api\Parser\EventParsingIterator;
use Aws\Api\Parser\RestJsonParser;
use Aws\Api\Service;
use Aws\Api\StructureShape;
use GuzzleHttp\Psr7\NoSeekStream;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/** @internal */
final class BedrockMiddleware implements Middleware
{
    private const VERSION = 'bedrock-2023-05-31';

    /**
     * @param \Closure(RequestInterface): RequestInterface $authorize
     */
    public function __construct(
        private StreamFactoryInterface $streamFactory,
        private \Closure $authorize,
    ) {}

    public function handle(RequestInterface $request, \Closure $callNext): ResponseInterface
    {
        $isCountTokens = str_ends_with($request->getUri()->getPath(), '/v1/messages/count_tokens');

        return $this->rewriteResponse($callNext(($this->authorize)($this->rewriteRequest($request))), $isCountTokens);
    }

    private function rewriteRequest(RequestInterface $request): RequestInterface
    {
        $path = $request->getUri()->getPath();

        if (str_ends_with($path, '/v1/messages') || str_ends_with($path, '/v1/messages/count_tokens')) {
            $isCountTokens = str_ends_with($path, '/v1/messages/count_tokens');
            $prefix = substr($path, 0, -strlen($isCountTokens ? '/v1/messages/count_tokens' : '/v1/messages'));

            $r = new RequestTransformer($request, $this->streamFactory);
            if ('' !== ($betas = $r->getHeader('anthropic-beta')) && null === $r->getBodyParam('anthropic_beta')) {
                $r->setBodyParam('anthropic_beta', array_map('trim', explode(',', $betas)));
            }
            $r->setBodyParamDefault('anthropic_version', self::VERSION)
                ->setHeader('X-Amzn-Bedrock-Accept', 'application/json')
                ->dropHeader('anthropic-version')
                ->dropHeader('anthropic-beta')
                ->dropQueryParam('beta');

            $model = $r->takeBodyParam('model');
            if (!is_string($model) || '' === $model) {
                throw new \InvalidArgumentException('Request body must contain a non-empty string `model`.');
            }
            $model = str_replace(['%40', '%3A'], ['@', ':'], rawurlencode($model));

            if ($isCountTokens) {
                $r->setBodyParam('max_tokens', 1024);
                $inner = base64_encode(json_encode($r->getBody(), flags: Util::JSON_ENCODE_FLAGS));

                return $r->replaceBody(['input' => ['invokeModel' => ['body' => $inner]]])
                    ->setPath("{$prefix}/model/{$model}/count-tokens")
                    ->build();
            }

            $action = (bool) $r->takeBodyParam('stream') ? 'invoke-with-response-stream' : 'invoke';

            return $r->setPath("{$prefix}/model/{$model}/{$action}")->build();
        }

        if (str_ends_with($path, '/v1/complete')) {
            return $request;
        }

        if (false !== ($i = strpos($path, '/v1/'))) {
            throw new AnthropicException(substr($path, $i).' is not supported on the Bedrock client.');
        }

        return $request;
    }

    private function rewriteResponse(ResponseInterface $response, bool $isCountTokens): ResponseInterface
    {
        if ($response->getStatusCode() >= 300) {
            return $response;
        }

        $contentType = $response->getHeaderLine('Content-Type');

        if (!str_contains($contentType, 'application/vnd.amazon.eventstream')) {
            // Bedrock count-tokens returns {inputTokens: N}; rename to the
            // SDK's snake_case shape so the generated converter applies.
            if ($isCountTokens && str_contains($contentType, 'application/json')) {
                $decoded = json_decode((string) $response->getBody(), true);
                if (is_array($decoded) && array_key_exists('inputTokens', $decoded)) {
                    $decoded = ['input_tokens' => $decoded['inputTokens']] + $decoded;
                    unset($decoded['inputTokens']);
                }

                return $response
                    ->withoutHeader('Content-Length')
                    ->withBody($this->streamFactory->createStream(
                        is_array($decoded) ? json_encode($decoded, flags: Util::JSON_ENCODE_FLAGS) : '{}',
                    ));
            }

            return $response;
        }

        $body = $response->getBody();

        return $response
            ->withHeader('Content-Type', 'text/event-stream')
            ->withoutHeader('Content-Length')
            ->withBody(new GeneratorStream(self::eventStreamToSse($body), $body));
    }

    private static function eventStreamToSse(StreamInterface $body): \Generator
    {
        if (!class_exists(ApiProvider::class)) {
            throw new \RuntimeException('The `aws/aws-sdk-php` package is required to decode Bedrock streaming responses.');
        }

        $service = self::bedrockRuntimeService();
        $shape = $service->getShapeMap()->resolve(['shape' => 'ResponseStream']);

        if (!$shape instanceof StructureShape) {
            throw new \RuntimeException('Unable to resolve Bedrock ResponseStream shape from the AWS SDK.');
        }

        $iterator = new EventParsingIterator(
            stream: new NoSeekStream(new ReadFillStream($body)),
            shape: $shape,
            parser: new RestJsonParser($service),
        );

        try {
            foreach ($iterator as $event) {
                if (!is_array($event)) {
                    continue;
                }
                if (isset($event['initial-response'])) {
                    continue;
                }
                if (!is_array($chunk = $event['chunk'] ?? null)) {
                    throw new \RuntimeException(json_encode($event, flags: Util::JSON_ENCODE_FLAGS));
                }

                $bytes = $chunk['bytes'] ?? null;
                if ($bytes instanceof StreamInterface) {
                    $bytes = $bytes->getContents();
                }
                if (!is_string($bytes)) {
                    continue;
                }

                $payload = Util::decodeJson($bytes);
                $type = is_array($payload) && is_string($payload['type'] ?? null) ? $payload['type'] : '';

                yield "event: {$type}\ndata: {$bytes}\n\n";
            }
        } catch (\Throwable $exception) {
            $error = json_encode(
                ['type' => 'error', 'error' => ['type' => 'api_error', 'message' => $exception->getMessage()]],
                flags: Util::JSON_ENCODE_FLAGS,
            );

            yield "event: error\ndata: {$error}\n\n";
        }
    }

    private static function bedrockRuntimeService(): Service
    {
        static $service = null;

        if (!$service instanceof Service) {
            $provider = ApiProvider::defaultProvider();
            $definition = ApiProvider::resolve($provider, 'api', 'bedrock-runtime', '2023-09-30');
            $service = new Service($definition, $provider);
        }

        return $service;
    }
}

/**
 * One read() returns one generator yield. Psr7\Utils::streamFor(Generator)
 * would wrap in PumpStream, whose read($n) keeps pulling until $n bytes are
 * buffered — with an 8KB consumer that parses dozens of frames from the
 * network before yielding the first.
 *
 * @internal
 */
final class GeneratorStream implements StreamInterface
{
    private bool $primed = false;

    /**
     * @param \Generator<string> $source
     */
    public function __construct(private ?\Generator $source, private StreamInterface $inner) {}

    public function read($length): string
    {
        if (null === $this->source) {
            return '';
        }
        if ($this->primed) {
            $this->source->next();
        }
        $this->primed = true;

        return $this->source->valid() ? $this->source->current() : '';
    }

    public function eof(): bool
    {
        return null === $this->source || ($this->primed && !$this->source->valid());
    }

    public function isReadable(): bool
    {
        return true;
    }

    public function close(): void
    {
        $this->source = null;
        $this->inner->close();
    }

    public function detach()
    {
        $this->source = null;

        return $this->inner->detach();
    }

    public function getSize(): ?int
    {
        return null;
    }

    public function tell(): int
    {
        throw new \RuntimeException('Stream is not seekable.');
    }

    public function isSeekable(): bool
    {
        return false;
    }

    public function seek($offset, $whence = SEEK_SET): void
    {
        throw new \RuntimeException('Stream is not seekable.');
    }

    public function rewind(): void
    {
        throw new \RuntimeException('Stream is not seekable.');
    }

    public function isWritable(): bool
    {
        return false;
    }

    public function write($string): int
    {
        throw new \RuntimeException('Stream is not writable.');
    }

    public function getContents(): string
    {
        $out = '';
        while (!$this->eof()) {
            $out .= $this->read(0);
        }

        return $out;
    }

    public function getMetadata($key = null)
    {
        return null === $key ? [] : null;
    }

    public function __toString(): string
    {
        return $this->getContents();
    }
}

/**
 * AWS's event-stream decoder calls valid() = !$stream->eof() between frames.
 * A network body's eof() goes true as soon as the last byte is read, so the
 * final parsed frame is dropped before it's yielded. This wrapper defers
 * eof() until a read returns empty.
 *
 * @internal
 */
final class ReadFillStream implements StreamInterface
{
    private bool $drained = false;

    public function __construct(private StreamInterface $stream) {}

    public function read($length): string
    {
        $buf = '';
        while (strlen($buf) < $length && !$this->stream->eof()) {
            $chunk = $this->stream->read($length - strlen($buf));
            if ('' === $chunk) {
                break;
            }
            $buf .= $chunk;
        }

        if ('' === $buf) {
            $this->drained = true;
        }

        return $buf;
    }

    public function eof(): bool
    {
        return $this->drained;
    }

    public function close(): void
    {
        $this->stream->close();
    }

    public function detach()
    {
        return $this->stream->detach();
    }

    public function getSize(): ?int
    {
        return $this->stream->getSize();
    }

    public function tell(): int
    {
        return $this->stream->tell();
    }

    public function isSeekable(): bool
    {
        return $this->stream->isSeekable();
    }

    public function seek($offset, $whence = SEEK_SET): void
    {
        $this->stream->seek($offset, $whence);
    }

    public function rewind(): void
    {
        $this->stream->rewind();
    }

    public function isWritable(): bool
    {
        return false;
    }

    public function write($string): int
    {
        throw new \RuntimeException('Stream is not writable.');
    }

    public function isReadable(): bool
    {
        return true;
    }

    public function getContents(): string
    {
        $out = '';
        while (!$this->eof()) {
            $out .= $this->read(8192);
        }

        return $out;
    }

    public function getMetadata($key = null)
    {
        return $this->stream->getMetadata($key);
    }

    public function __toString(): string
    {
        return $this->getContents();
    }
}
