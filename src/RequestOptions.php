<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api as Property;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Implementation\Omittable;
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
 *   extraHeaders?: array<string, string|int|null|list<string|int>>|null,
 *   extraQueryParams?: array<string, mixed>|null,
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

    /** @var array<string, string|int|list<string|int>|null> $extraHeaders */
    #[Property]
    public array $extraHeaders = [];

    /** @var array<string, mixed> $extraQueryParams */
    #[Property]
    public array $extraQueryParams = [];

    #[Property]
    public mixed $extraBodyParams;

    #[Property(optional: true)]
    public ?ClientInterface $transporter;

    #[Property(optional: true)]
    public ?UriFactoryInterface $uriFactory;

    #[Property(optional: true)]
    public ?StreamFactoryInterface $streamFactory;

    #[Property(optional: true)]
    public ?RequestFactoryInterface $requestFactory;

    /**
     * @param array<string, string|int|list<string|int>|null>|null $extraHeaders
     * @param array<string, mixed>|null $extraQueryParams
     * @param mixed|Omittable $extraBodyParams
     */
    public function __construct(
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
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        null !== $timeout && $this->timeout = $timeout;
        null !== $maxRetries && $this->maxRetries = $maxRetries;
        null !== $initialRetryDelay && $this
            ->initialRetryDelay = $initialRetryDelay
        ;
        null !== $maxRetryDelay && $this->maxRetryDelay = $maxRetryDelay;
        null !== $extraHeaders && $this->extraHeaders = $extraHeaders;
        null !== $extraQueryParams && $this->extraQueryParams = $extraQueryParams;
        omit !== $extraBodyParams && $this->extraBodyParams = $extraBodyParams;
        null !== $transporter && $this->transporter = $transporter;
        null !== $uriFactory && $this->uriFactory = $uriFactory;
        null !== $streamFactory && $this->streamFactory = $streamFactory;
        null !== $requestFactory && $this->requestFactory = $requestFactory;
    }

    /**
     * @param request_opts|null $options
     */
    public static function parse(RequestOptions|array|null $options): self
    {
        if (is_null($options)) {
            return new self;
        }

        if ($options instanceof self) {
            return $options;
        }

        $opts = new self;
        $opts->__unserialize($options);

        return $opts;
    }
}
