<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Tracing;
use Anthropic\Lib\Middleware\BetaFallbackState;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * @phpstan-type MiddlewareItem = Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface, RequestOptions=): ResponseInterface
 * @phpstan-type RequestOptionShape = array{
 *   timeout?: float|null,
 *   maxRetries?: int|null,
 *   initialRetryDelay?: float|null,
 *   maxRetryDelay?: float|null,
 *   extraHeaders?: array<string,string|int|null|list<string|int>>|null,
 *   extraQueryParams?: array<string,mixed>|null,
 *   extraBodyParams?: mixed,
 *   middleware?: list<MiddlewareItem>|null,
 *   fallbackState?: BetaFallbackState|null,
 *   transporter?: ClientInterface|null,
 *   streamingTransporter?: ClientInterface|null,
 *   uriFactory?: UriFactoryInterface|null,
 *   streamFactory?: StreamFactoryInterface|null,
 *   requestFactory?: RequestFactoryInterface|null,
 *   openTelemetry?: array{conversationId?: string|null}|null,
 * }
 * @phpstan-type RequestOpts = null|RequestOptions|RequestOptionShape
 */
final class RequestOptions implements BaseModel
{
    /** @use SdkModel<RequestOptionShape> */
    use SdkModel;

    public const DEFAULT_MAX_RETRIES = 2;

    public const DEFAULT_INITIAL_RETRY_DELAY = 0.5;

    public const DEFAULT_MAX_RETRY_DELAY = 8.0;

    /**
     * Request timeout in seconds. When unset the intended default is 600s,
     * but that is advisory only: the timeout is enforced by the
     * caller-supplied transport, not by this SDK, so nothing in src reads it.
     */
    #[Optional]
    public ?float $timeout;

    #[Optional]
    public ?int $maxRetries;

    #[Optional]
    public ?float $initialRetryDelay;

    #[Optional]
    public ?float $maxRetryDelay;

    /** @var array<string,string|int|list<string|int>|null>|null $extraHeaders */
    #[Optional]
    public ?array $extraHeaders;

    /** @var array<string,mixed>|null $extraQueryParams */
    #[Optional]
    public ?array $extraQueryParams;

    #[Optional]
    public mixed $extraBodyParams;

    /**
     * Middleware to run around each HTTP attempt, outermost first. Each
     * entry is a callable `(RequestInterface $request, callable $next):
     * ResponseInterface` — a class implementing {@see Middleware} works
     * anywhere a callable does — where `$next` invokes the rest of the
     * chain. Request-level middleware run inside (after) client-level
     * middleware.
     *
     * @var list<MiddlewareItem>|null $middleware
     */
    #[Optional]
    public ?array $middleware;

    /**
     * Shared pin consumed by {@see \Anthropic\Lib\Middleware\RefusalFallbackMiddleware};
     * a request-level value overrides the middleware's constructor state.
     */
    #[Optional]
    public ?BetaFallbackState $fallbackState;

    #[Optional]
    public ?ClientInterface $transporter;

    #[Optional]
    public ?ClientInterface $streamingTransporter;

    #[Optional]
    public ?UriFactoryInterface $uriFactory;

    #[Optional]
    public ?StreamFactoryInterface $streamFactory;

    #[Optional]
    public ?RequestFactoryInterface $requestFactory;

    /**
     * OpenTelemetry settings for this request's span. The SDK does not send them to the API. `conversationId`
     * becomes the span's `gen_ai.conversation.id`. It is the only key: any other, or a value that is no string, is
     * refused with an `InvalidArgumentException`. A request's settings replace those in the request options of its
     * client whole, as every request option does: only a request that leaves the option out keeps the client's.
     *
     * @var array{conversationId?: string|null}|null $openTelemetry
     */
    #[Optional]
    public ?array $openTelemetry;

    /**
     * The query pairs that tell the operation apart from the others with its path in the OpenAPI document. Only the SDK
     * sets them, with {@see self::withQualifiers()}: they are no request option, so an array of request options has no key for them.
     *
     * @var array<string,string>|null
     */
    private ?array $qualifiers = null;

    /**
     * What the SDK method that makes the request knows of its API call, for the call's span. Only the SDK sets it, with
     * {@see self::withApiCall()}: it is no request option, so an array of request options has no key for it.
     */
    private ?ApiCallInfo $apiCall = null;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @param RequestOpts|null $options
     */
    public static function parse(RequestOptions|array|null ...$options): self
    {
        $parsed = array_map(static fn ($o) => $o instanceof self ? $o->toProperties() : $o ?? [], array: $options);

        // @phpstan-ignore-next-line argument.type
        $self = self::with(...array_merge(...$parsed));
        // The last options that have what the SDK sets win, as with every request option.
        foreach ($options as $o) {
            if ($o instanceof self && !is_null($o->qualifiers)) {
                $self->qualifiers = $o->qualifiers;
            }
            if ($o instanceof self && !is_null($o->apiCall)) {
                $self->apiCall = $o->apiCall;
            }
        }

        return $self;
    }

    /**
     * @param array<string,string|int|list<string|int>|null>|null $extraHeaders
     * @param array<string,mixed>|null $extraQueryParams
     * @param list<MiddlewareItem>|null $middleware
     * @param array{conversationId?: string|null}|null $openTelemetry
     */
    public static function with(
        ?float $timeout = null,
        ?int $maxRetries = null,
        ?float $initialRetryDelay = null,
        ?float $maxRetryDelay = null,
        ?array $extraHeaders = null,
        ?array $extraQueryParams = null,
        mixed $extraBodyParams = null,
        ?array $middleware = null,
        ?BetaFallbackState $fallbackState = null,
        ?ClientInterface $transporter = null,
        ?ClientInterface $streamingTransporter = null,
        ?UriFactoryInterface $uriFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?array $openTelemetry = null,
    ): self {
        Tracing::validateRequestOption($openTelemetry);
        $self = new self;

        null !== $timeout && $self->timeout = $timeout;
        null !== $maxRetries && $self->maxRetries = $maxRetries;
        null !== $initialRetryDelay && $self->initialRetryDelay = $initialRetryDelay;
        null !== $maxRetryDelay && $self->maxRetryDelay = $maxRetryDelay;
        null !== $extraHeaders && $self->extraHeaders = $extraHeaders;
        null !== $extraQueryParams && $self->extraQueryParams = $extraQueryParams;
        null !== $extraBodyParams && $self->extraBodyParams = $extraBodyParams;
        null !== $middleware && $self->middleware = $middleware;
        null !== $fallbackState && $self->fallbackState = $fallbackState;
        null !== $transporter && $self->transporter = $transporter;
        null !== $streamingTransporter && $self
            ->streamingTransporter = $streamingTransporter
        ;
        null !== $uriFactory && $self->uriFactory = $uriFactory;
        null !== $streamFactory && $self->streamFactory = $streamFactory;
        null !== $requestFactory && $self->requestFactory = $requestFactory;
        null !== $openTelemetry && $self->openTelemetry = $openTelemetry;

        return $self;
    }

    public function withTimeout(float $timeout): self
    {
        $self = clone $this;
        $self->timeout = $timeout;

        return $self;
    }

    public function withMaxRetries(int $maxRetries): self
    {
        $self = clone $this;
        $self->maxRetries = $maxRetries;

        return $self;
    }

    public function withInitialRetryDelay(float $initialRetryDelay): self
    {
        $self = clone $this;
        $self->initialRetryDelay = $initialRetryDelay;

        return $self;
    }

    public function withMaxRetryDelay(float $maxRetryDelay): self
    {
        $self = clone $this;
        $self->maxRetryDelay = $maxRetryDelay;

        return $self;
    }

    /**
     * @param array<string,string|int|list<string|int>|null> $extraHeaders
     */
    public function withExtraHeaders(array $extraHeaders): self
    {
        $self = clone $this;
        $self->extraHeaders = $extraHeaders;

        return $self;
    }

    /**
     * @param array<string,mixed> $extraQueryParams
     */
    public function withExtraQueryParams(array $extraQueryParams): self
    {
        $self = clone $this;
        $self->extraQueryParams = $extraQueryParams;

        return $self;
    }

    public function withExtraBodyParams(mixed $extraBodyParams): self
    {
        $self = clone $this;
        $self->extraBodyParams = $extraBodyParams;

        return $self;
    }

    public function withTransporter(ClientInterface $transporter): self
    {
        $self = clone $this;
        $self->transporter = $transporter;

        return $self;
    }

    public function withStreamingTransporter(
        ClientInterface $streamingTransporter
    ): self {
        $self = clone $this;
        $self->streamingTransporter = $streamingTransporter;

        return $self;
    }

    public function withUriFactory(UriFactoryInterface $uriFactory): self
    {
        $self = clone $this;
        $self->uriFactory = $uriFactory;

        return $self;
    }

    public function withStreamFactory(
        StreamFactoryInterface $streamFactory
    ): self {
        $self = clone $this;
        $self->streamFactory = $streamFactory;

        return $self;
    }

    public function withRequestFactory(
        RequestFactoryInterface $requestFactory
    ): self {
        $self = clone $this;
        $self->requestFactory = $requestFactory;

        return $self;
    }

    /**
     * @param array{conversationId?: string|null} $openTelemetry
     */
    public function withOpenTelemetry(array $openTelemetry): self
    {
        Tracing::validateRequestOption($openTelemetry);
        $self = clone $this;
        $self->openTelemetry = $openTelemetry;

        return $self;
    }

    /**
     * @internal
     *
     * These options for a request to the operation that `$qualifiers` tell apart
     *
     * @param array<string,string> $qualifiers
     */
    public function withQualifiers(array $qualifiers): self
    {
        $self = clone $this;
        $self->qualifiers = $qualifiers;

        return $self;
    }

    /**
     * @internal
     *
     * What the SDK method that makes the request set with {@see self::withQualifiers()}
     *
     * @return array<string,string>|null
     */
    public function qualifiers(): ?array
    {
        return $this->qualifiers;
    }

    /**
     * @internal
     *
     * These options for a request of the API call `$apiCall`, which the SDK method that makes the request describes
     * for the call's span
     */
    public function withApiCall(?ApiCallInfo $apiCall): self
    {
        $self = clone $this;
        $self->apiCall = $apiCall;

        return $self;
    }

    /**
     * @internal
     *
     * What the SDK method that makes the request set with {@see self::withApiCall()}
     */
    public function apiCall(): ?ApiCallInfo
    {
        return $this->apiCall;
    }
}
