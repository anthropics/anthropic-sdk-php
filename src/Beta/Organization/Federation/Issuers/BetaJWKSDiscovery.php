<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Issuers;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * JWKS via the issuer's OIDC discovery document.
 *
 * @phpstan-type BetaJWKSDiscoveryShape = array{
 *   type: 'discovery', caCertPEM?: string|null, discoveryBase?: string|null
 * }
 */
final class BetaJWKSDiscovery implements BaseModel
{
    /** @use SdkModel<BetaJWKSDiscoveryShape> */
    use SdkModel;

    /** @var 'discovery' $type */
    #[Required]
    public string $type = 'discovery';

    /**
     * Optional custom CA (PEM) for TLS verification of the JWKS fetch.
     */
    #[Optional('ca_cert_pem', nullable: true)]
    public ?string $caCertPEM;

    /**
     * Set when the discovery URL differs from `issuer_url`.
     */
    #[Optional('discovery_base', nullable: true)]
    public ?string $discoveryBase;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        ?string $caCertPEM = null,
        ?string $discoveryBase = null
    ): self {
        $self = new self;

        null !== $caCertPEM && $self['caCertPEM'] = $caCertPEM;
        null !== $discoveryBase && $self['discoveryBase'] = $discoveryBase;

        return $self;
    }

    /**
     * @param 'discovery' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

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

    /**
     * Set when the discovery URL differs from `issuer_url`.
     */
    public function withDiscoveryBase(?string $discoveryBase): self
    {
        $self = clone $this;
        $self['discoveryBase'] = $discoveryBase;

        return $self;
    }
}
