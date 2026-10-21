<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Token endpoint uses POST body authentication with client credentials.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthPostParamShape = array{
 *   clientSecret: string, type: 'client_secret_post'
 * }
 */
final class ManagedAgentsTokenEndpointAuthPostParam implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthPostParamShape> */
    use SdkModel;

    /** @var 'client_secret_post' $type */
    #[Required(type: new ConstantOf('client_secret_post'))]
    public string $type = 'client_secret_post';

    /**
     * The OAuth client secret, sent to `token_endpoint` in the POST body.
     */
    #[Required('client_secret')]
    public string $clientSecret;

    /**
     * `new ManagedAgentsTokenEndpointAuthPostParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTokenEndpointAuthPostParam::with(clientSecret: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTokenEndpointAuthPostParam())->withClientSecret(...)
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
    public static function with(string $clientSecret): self
    {
        $self = new self;

        $self['clientSecret'] = $clientSecret;

        return $self;
    }

    /**
     * The OAuth client secret, sent to `token_endpoint` in the POST body.
     */
    public function withClientSecret(string $clientSecret): self
    {
        $self = clone $this;
        $self['clientSecret'] = $clientSecret;

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
}
