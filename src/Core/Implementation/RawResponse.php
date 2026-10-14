<?php

namespace Anthropic\Core\Implementation;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Concerns\ResponseProxy;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Util;
use Anthropic\Lib\Tracing\Tracing;
use Anthropic\RequestOptions;
use OpenTelemetry\API\Trace\SpanInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-import-type NormalizedRequest from \Anthropic\Core\BaseClient
 *
 * @internal
 *
 * @template R
 *
 * @implements BaseResponse<R>
 */
class RawResponse implements BaseResponse
{
    use ResponseProxy;

    private mixed $decodedBody;

    /** @var R */
    private mixed $coercedResponse;

    private bool $decoded = false;
    private bool $coerced = false;

    /** @var (\Closure(R, mixed): R)|null */
    private ?\Closure $transform = null;

    /**
     * @param NormalizedRequest $requestInfo
     * @param list<string|int>|string|int|null $unwrap
     * @param SpanInterface|null $span the call span, for this response to end
     * @param int|float $startTime when the API call started, by `hrtime`
     */
    public function __construct(
        private BaseClient $client,
        private RequestOptions $options,
        private RequestInterface $request,
        private ResponseInterface $response,
        private array $requestInfo,
        private array|string|int|null $unwrap,
        private Converter|ConverterSource|string $convert,
        private ?string $page,
        private ?string $stream,
        private ?SpanInterface $span = null,
        private int|float $startTime = 0,
    ) {}

    /**
     * The call span ends at `parse()`, with what the body says, or when it returns a stream, once that has been read. A response the application takes raw and never parses ends the span here instead, with what the headers say, as soon as PHP frees it. The response of a streaming call that is never parsed is a stream the application never read: a cancellation, whose span has no status.
     */
    public function __destruct()
    {
        if (!is_null($this->span)) {
            Tracing::endApiCallSpan($this->client, $this->span, ['request' => $this->requestInfo, 'options' => $this->options, 'startTime' => $this->startTime, 'response' => $this->response, 'cancelled' => !is_null($this->stream)]);
        }
    }

    /**
     * Makes `parse()` return what `$transform` makes of the parsed body. `$transform` runs before the call span ends, so the SDK method that made the request records with it, on the span it started, what comes from the response. It also gets the decoded body that the parsed one was built from.
     *
     * @internal
     *
     * @param \Closure(R, mixed): R $transform
     */
    public function thenUnwrap(\Closure $transform): static
    {
        $this->transform = $transform;

        return $this;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getRequestID(): ?string
    {
        return $this->response->getHeaderLine('request-id') ?: null;
    }

    public function getWorkspaceID(): ?string
    {
        return $this->response->getHeaderLine('anthropic-workspace-id') ?: null;
    }

    public function parse(): mixed
    {
        if (!$this->coerced) {
            [$span, $this->span] = [$this->span, null];
            // @phpstan-ignore-next-line assign.propertyType
            $this->coercedResponse = is_null($span) ? $this->coerceAndTransform() : $this->coerceTraced($span);
            $this->coerced = true;
        }

        return $this->coercedResponse;
    }

    /**
     * The call span moves to the copy: the copy is the response the application goes on to parse or drop, and only one response may end the span.
     */
    private function withResponse(ResponseInterface $response): static
    {
        $self = clone $this;
        $self->response = $response;
        $this->span = null;

        return $self;
    }

    /**
     * The response body as `coerce` returns it, ending `$span` with it, or with what parsing the body threw. A stream comes back as a `TracedStream`, which ends `$span` later.
     */
    private function coerceTraced(SpanInterface $span): mixed
    {
        $result = ['request' => $this->requestInfo, 'options' => $this->options, 'startTime' => $this->startTime, 'response' => $this->response];

        try {
            $data = $this->coerceAndTransform();
        } catch (\Throwable $e) {
            Tracing::endApiCallSpan($this->client, $span, [...$result, 'error' => $e]);

            throw $e;
        }

        return Tracing::endApiCallSpan($this->client, $span, [...$result, 'data' => $data]);
    }

    private function getDecoded(): mixed
    {
        if (!$this->decoded) {
            $decoded = Util::decodeContent($this->response);
            if (!is_null($this->unwrap)) {
                $decoded = Util::dig($decoded, key: $this->unwrap);
            }
            $this->decodedBody = $decoded;
            $this->decoded = true;
        }

        return $this->decodedBody;
    }

    /**
     * The response body as `coerce` returns it, or what the transform of `thenUnwrap` makes of it.
     */
    private function coerceAndTransform(): mixed
    {
        $data = $this->coerce();

        return is_null($this->transform) ? $data : ($this->transform)($data, $this->getDecoded());
    }

    /**
     * The response body, as the stream, the page, or the value it holds.
     */
    private function coerce(): mixed
    {
        if (!is_null($this->stream)) {
            return new $this->stream(
                convert: $this->convert,
                request: $this->request,
                response: $this->response,
                parsedBody: $this->getDecoded(),
            );
        }
        if (!is_null($this->page)) {
            return new $this->page(
                convert: $this->convert,
                client: $this->client,
                requestInfo: $this->requestInfo,
                options: $this->options,
                response: $this->response,
                parsedBody: $this->getDecoded(),
            );
        }

        return Conversion::coerce($this->convert, value: $this->getDecoded());
    }
}
