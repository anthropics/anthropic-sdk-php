<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * JWKS fetched from a fixed endpoint.
 *
 * @phpstan-type BetaJWKSExplicitURLShape = array{
 *   type: 'explicit_url', url: string, caCertPEM?: string|null
 * }
 */
final class BetaJWKSExplicitURL implements BaseModel
{
    /** @use SdkModel<BetaJWKSExplicitURLShape> */
    use SdkModel;

    /** @var 'explicit_url' $type */
    #[Required]
    public string $type = 'explicit_url';

    /**
     * JWKS endpoint.
     */
    #[Required]
    public string $url;

    /**
     * Optional custom CA (PEM) for TLS verification of the JWKS fetch.
     */
    #[Optional('ca_cert_pem', nullable: true)]
    public ?string $caCertPEM;

    /**
     * `new BetaJWKSExplicitURL()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaJWKSExplicitURL::with(url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaJWKSExplicitURL)->withURL(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $url, ?string $caCertPEM = null): self
    {
        $self = new self;

        $self['url'] = $url;

        null !== $caCertPEM && $self['caCertPEM'] = $caCertPEM;

        return $self;
    }

    /**
     * @param 'explicit_url' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * JWKS endpoint.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }

    /**
     * Optional custom CA (PEM) for TLS verification of the JWKS fetch.
     */
    public function withCACertPEM(?string $caCertPEM): self
    {
        $self = clone $this;
        $self['caCertPEM'] = $caCertPEM;

        return $self;
    }
}
