<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Token endpoint uses HTTP Basic authentication with client credentials.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthBasicParamShape = array{
 *   clientSecret: string, type: 'client_secret_basic'
 * }
 */
final class ManagedAgentsTokenEndpointAuthBasicParam implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthBasicParamShape> */
    use SdkModel;

    /** @var 'client_secret_basic' $type */
    #[Required(type: new ConstantOf('client_secret_basic'))]
    public string $type = 'client_secret_basic';

    /**
     * The OAuth client secret, sent to `token_endpoint` with HTTP Basic authentication.
     */
    #[Required('client_secret')]
    public string $clientSecret;

    /**
     * `new ManagedAgentsTokenEndpointAuthBasicParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTokenEndpointAuthBasicParam::with(clientSecret: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTokenEndpointAuthBasicParam())->withClientSecret(...)
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
     * The OAuth client secret, sent to `token_endpoint` with HTTP Basic authentication.
     */
    public function withClientSecret(string $clientSecret): self
    {
        $self = clone $this;
        $self['clientSecret'] = $clientSecret;

        return $self;
    }

    /**
     * @param 'client_secret_basic' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
