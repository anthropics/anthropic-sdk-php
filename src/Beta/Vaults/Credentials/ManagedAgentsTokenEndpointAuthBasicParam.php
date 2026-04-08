<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicParam\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Token endpoint uses HTTP Basic authentication with client credentials.
 *
 * @phpstan-type ManagedAgentsTokenEndpointAuthBasicParamShape = array{
 *   clientSecret: string, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsTokenEndpointAuthBasicParam implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTokenEndpointAuthBasicParamShape> */
    use SdkModel;

    /**
     * OAuth client secret.
     */
    #[Required('client_secret')]
    public string $clientSecret;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsTokenEndpointAuthBasicParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTokenEndpointAuthBasicParam::with(clientSecret: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTokenEndpointAuthBasicParam)
     *   ->withClientSecret(...)
     *   ->withType(...)
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
    public static function with(string $clientSecret, Type|string $type): self
    {
        $self = new self;

        $self['clientSecret'] = $clientSecret;
        $self['type'] = $type;

        return $self;
    }

    /**
     * OAuth client secret.
     */
    public function withClientSecret(string $clientSecret): self
    {
        $self = clone $this;
        $self['clientSecret'] = $clientSecret;

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
}
