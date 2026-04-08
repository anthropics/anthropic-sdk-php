<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostUpdateParam\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Updated POST body authentication parameters for the token endpoint.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthPostUpdateParamShape = array{
 *   type: Type|value-of<Type>, clientSecret?: string|null
 * }
 */
final class ManagedAgentsTokenEndpointAuthPostUpdateParam implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthPostUpdateParamShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Updated OAuth client secret.
     */
    #[Optional('client_secret', nullable: true)]
    public ?string $clientSecret;

    /**
     * `new ManagedAgentsTokenEndpointAuthPostUpdateParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTokenEndpointAuthPostUpdateParam::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTokenEndpointAuthPostUpdateParam)->withType(...)
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
     *
     * @param Type|value-of<Type> $type
     */
    public static function with(
        Type|string $type,
        ?string $clientSecret = null
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $clientSecret && $self['clientSecret'] = $clientSecret;

        return $self;
    }

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Updated OAuth client secret.
     */
    public function withClientSecret(?string $clientSecret): self
    {
        $self = clone $this;
        $self['clientSecret'] = $clientSecret;

        return $self;
    }
}
