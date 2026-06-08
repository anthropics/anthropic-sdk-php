<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required as Property;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

/**
 * @phpstan-type MiddlewareItem = Middleware|callable(RequestInterface, \Closure(RequestInterface): ResponseInterface): ResponseInterface
 * @phpstan-type RequestOptionShape = array{
 *   timeout?: float|null,
 *   maxRetries?: int|null,
 *   initialRetryDelay?: float|null,
 *   maxRetryDelay?: float|null,
 *   extraHeaders?: array<string,string|int|null|list<string|int>>|null,
 *   extraQueryParams?: array<string,mixed>|null,
 *   extraBodyParams?: mixed,
 *   transporter?: ClientInterface|null,
 *   streamingTransporter?: ClientInterface|null,
 *   uriFactory?: UriFactoryInterface|null,
 *   streamFactory?: StreamFactoryInterface|null,
 *   requestFactory?: RequestFactoryInterface|null,
 *   middleware?: list<MiddlewareItem>|null,
 * }
 * @phpstan-type RequestOpts = null|RequestOptions|RequestOptionShape
 */
final class RequestOptions implements BaseModel
{
    /** @use SdkModel<RequestOptionShape> */
    use SdkModel;

    #[Property]
    public float $timeout = 600;

    #[Property]
    public int $maxRetries = 2;

    #[Property]
    public float $initialRetryDelay = 0.5;

    #[Property]
    public float $maxRetryDelay = 8.0;

    /** @var array<string,string|int|list<string|int>|null>|null $extraHeaders */
    #[Optional]
    public ?array $extraHeaders;

    /** @var array<string,mixed>|null $extraQueryParams */
    #[Optional]
    public ?array $extraQueryParams;

    #[Optional]
    public mixed $extraBodyParams;

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

    /** @var list<MiddlewareItem>|null $middleware */
    #[Optional]
    public ?array $middleware;

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
        return self::with(...array_merge(...$parsed));
    }

    /**
     * @param array<string,string|int|list<string|int>|null>|null $extraHeaders
     * @param array<string,mixed>|null $extraQueryParams
     * @param list<MiddlewareItem>|null $middleware
     */
    public static function with(
        ?float $timeout = null,
        ?int $maxRetries = null,
        ?float $initialRetryDelay = null,
        ?float $maxRetryDelay = null,
        ?array $extraHeaders = null,
        ?array $extraQueryParams = null,
        mixed $extraBodyParams = null,
        ?ClientInterface $transporter = null,
        ?ClientInterface $streamingTransporter = null,
        ?UriFactoryInterface $uriFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?array $middleware = null,
    ): self {
        $self = new self;

        null !== $timeout && $self->timeout = $timeout;
        null !== $maxRetries && $self->maxRetries = $maxRetries;
        null !== $initialRetryDelay && $self
            ->initialRetryDelay = $initialRetryDelay
        ;
        null !== $maxRetryDelay && $self->maxRetryDelay = $maxRetryDelay;
        null !== $extraHeaders && $self->extraHeaders = $extraHeaders;
        null !== $extraQueryParams && $self->extraQueryParams = $extraQueryParams;
        null !== $extraBodyParams && $self->extraBodyParams = $extraBodyParams;
        null !== $transporter && $self->transporter = $transporter;
        null !== $streamingTransporter && $self
            ->streamingTransporter = $streamingTransporter
        ;
        null !== $uriFactory && $self->uriFactory = $uriFactory;
        null !== $streamFactory && $self->streamFactory = $streamFactory;
        null !== $requestFactory && $self->requestFactory = $requestFactory;
        null !== $middleware && $self->middleware = $middleware;

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
     * @param list<MiddlewareItem> $middleware
     */
    public function withMiddleware(array $middleware): self
    {
        $self = clone $this;
        $self->middleware = $middleware;

        return $self;
    }
}
