<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Updated POST body authentication parameters for the token endpoint.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthPostUpdateParamShape = array{
 *   type: 'client_secret_post', clientSecret?: string|null
 * }
 */
final class ManagedAgentsTokenEndpointAuthPostUpdateParam implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthPostUpdateParamShape> */
    use SdkModel;

    /** @var 'client_secret_post' $type */
    #[Required(type: new ConstantOf('client_secret_post'))]
    public string $type = 'client_secret_post';

    /**
     * A new OAuth client secret to replace the stored one.
     *
     * The credential must already use `client_secret_basic` or `client_secret_post`. It keeps its current `token_endpoint_auth` type, even if the `type` sent with this secret is the other one.
     */
    #[Optional('client_secret', nullable: true)]
    public ?string $clientSecret;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?string $clientSecret = null): self
    {
        $self = new self;

        null !== $clientSecret && $self['clientSecret'] = $clientSecret;

        return $self;
    }

    /**
     * @param 'client_secret_post' $type
     */
    public function withType(string $type): self
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
