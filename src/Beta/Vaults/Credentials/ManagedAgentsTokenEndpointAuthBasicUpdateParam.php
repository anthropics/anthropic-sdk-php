<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicUpdateParam\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Updated HTTP Basic authentication parameters for the token endpoint.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthBasicUpdateParamShape = array{
 *   type: Type|value-of<Type>, clientSecret?: string|null
 * }
 */
final class ManagedAgentsTokenEndpointAuthBasicUpdateParam implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthBasicUpdateParamShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * A new OAuth client secret to replace the stored one.
     *
     * The credential must already use `client_secret_basic` or `client_secret_post`. It keeps its current `token_endpoint_auth` type, even if the `type` sent with this secret is the other one.
     */
    #[Optional('client_secret', nullable: true)]
    public ?string $clientSecret;

    /**
     * `new ManagedAgentsTokenEndpointAuthBasicUpdateParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTokenEndpointAuthBasicUpdateParam::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTokenEndpointAuthBasicUpdateParam())->withType(...)
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
     * A new OAuth client secret to replace the stored one.
     *
     * The credential must already use `client_secret_basic` or `client_secret_post`. It keeps its current `token_endpoint_auth` type, even if the `type` sent with this secret is the other one.
     */
    public function withClientSecret(?string $clientSecret): self
    {
        $self = clone $this;
        $self['clientSecret'] = $clientSecret;

        return $self;
    }
}
