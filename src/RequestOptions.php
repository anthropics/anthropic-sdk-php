<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api as Property;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Implementation\Omit;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

use const Anthropic\Core\OMIT as omit;

/**
 * @phpstan-type request_options = array{
 *   timeout?: float|null,
 *   maxRetries?: int|null,
 *   initialRetryDelay?: float|null,
 *   maxRetryDelay?: float|null,
 *   extraHeaders?: array<string,string|int|null|list<string|int>>|null,
 *   extraQueryParams?: array<string,mixed>|null,
 *   extraBodyParams?: mixed,
 *   transporter?: ClientInterface|null,
 *   uriFactory?: UriFactoryInterface|null,
 *   streamFactory?: StreamFactoryInterface|null,
 *   requestFactory?: RequestFactoryInterface|null,
 * }
 * @phpstan-type request_opts = null|RequestOptions|request_options
 */
final class RequestOptions implements BaseModel
{
    /** @use SdkModel<request_options> */
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
    #[Property(optional: true)]
    public ?array $extraHeaders;

    /** @var array<string,mixed>|null $extraQueryParams */
    #[Property(optional: true)]
    public ?array $extraQueryParams;

    #[Property(optional: true)]
    public mixed $extraBodyParams;

    #[Property(optional: true)]
    public ?ClientInterface $transporter;

    #[Property(optional: true)]
    public ?UriFactoryInterface $uriFactory;

    #[Property(optional: true)]
    public ?StreamFactoryInterface $streamFactory;

    #[Property(optional: true)]
    public ?RequestFactoryInterface $requestFactory;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * @param request_opts|null $options
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
     * @param mixed|Omit $extraBodyParams
     */
    public static function with(
        ?float $timeout = null,
        ?int $maxRetries = null,
        ?float $initialRetryDelay = null,
        ?float $maxRetryDelay = null,
        ?array $extraHeaders = null,
        ?array $extraQueryParams = null,
        mixed $extraBodyParams = omit,
        ?ClientInterface $transporter = null,
        ?UriFactoryInterface $uriFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?RequestFactoryInterface $requestFactory = null,
    ): self {
        $obj = new self;

        null !== $timeout && $obj->timeout = $timeout;
        null !== $maxRetries && $obj->maxRetries = $maxRetries;
        null !== $initialRetryDelay && $obj->initialRetryDelay = $initialRetryDelay;
        null !== $maxRetryDelay && $obj->maxRetryDelay = $maxRetryDelay;
        null !== $extraHeaders && $obj->extraHeaders = $extraHeaders;
        null !== $extraQueryParams && $obj->extraQueryParams = $extraQueryParams;
        omit !== $extraBodyParams && $obj->extraBodyParams = $extraBodyParams;
        null !== $transporter && $obj->transporter = $transporter;
        null !== $uriFactory && $obj->uriFactory = $uriFactory;
        null !== $streamFactory && $obj->streamFactory = $streamFactory;
        null !== $requestFactory && $obj->requestFactory = $requestFactory;

        return $obj;
    }

    public function withTimeout(float $timeout): self
    {
        $obj = clone $this;
        $obj->timeout = $timeout;

        return $obj;
    }

    public function withMaxRetries(int $maxRetries): self
    {
        $obj = clone $this;
        $obj->maxRetries = $maxRetries;

        return $obj;
    }

    public function withInitialRetryDelay(float $initialRetryDelay): self
    {
        $obj = clone $this;
        $obj->initialRetryDelay = $initialRetryDelay;

        return $obj;
    }

    public function withMaxRetryDelay(float $maxRetryDelay): self
    {
        $obj = clone $this;
        $obj->maxRetryDelay = $maxRetryDelay;

        return $obj;
    }

    /**
     * @param array<string,string|int|list<string|int>|null> $extraHeaders
     */
    public function withExtraHeaders(array $extraHeaders): self
    {
        $obj = clone $this;
        $obj->extraHeaders = $extraHeaders;

        return $obj;
    }

    /**
     * @param array<string,mixed> $extraQueryParams
     */
    public function withExtraQueryParams(array $extraQueryParams): self
    {
        $obj = clone $this;
        $obj->extraQueryParams = $extraQueryParams;

        return $obj;
    }

    public function withExtraBodyParams(mixed $extraBodyParams): self
    {
        $obj = clone $this;
        $obj->extraBodyParams = $extraBodyParams;

        return $obj;
    }

    public function withTransporter(ClientInterface $transporter): self
    {
        $obj = clone $this;
        $obj->transporter = $transporter;

        return $obj;
    }

    public function withUriFactory(UriFactoryInterface $uriFactory): self
    {
        $obj = clone $this;
        $obj->uriFactory = $uriFactory;

        return $obj;
    }

    public function withStreamFactory(
        StreamFactoryInterface $streamFactory
    ): self {
        $obj = clone $this;
        $obj->streamFactory = $streamFactory;

        return $obj;
    }

    public function withRequestFactory(
        RequestFactoryInterface $requestFactory
    ): self {
        $obj = clone $this;
        $obj->requestFactory = $requestFactory;

        return $obj;
    }
}
