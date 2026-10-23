<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type AnalyticsFederatedActorOIDCProviderShape = array{
 *   issuer: string|null, type: 'oidc'
 * }
 */
final class AnalyticsFederatedActorOIDCProvider implements BaseModel
{
    /** @use SdkModel<AnalyticsFederatedActorOIDCProviderShape> */
    use SdkModel;

    /** @var 'oidc' $type */
    #[Required(type: new ConstantOf('oidc'))]
    public string $type = 'oidc';

    /**
     * The federation issuer's URL.
     */
    #[Required]
    public ?string $issuer;

    /**
     * `new AnalyticsFederatedActorOIDCProvider()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsFederatedActorOIDCProvider::with(issuer: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsFederatedActorOIDCProvider())->withIssuer(...)
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
    public static function with(?string $issuer): self
    {
        $self = new self;

        $self['issuer'] = $issuer;

        return $self;
    }

    /**
     * The federation issuer's URL.
     */
    public function withIssuer(?string $issuer): self
    {
        $self = clone $this;
        $self['issuer'] = $issuer;

        return $self;
    }

    /**
     * @param 'oidc' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
