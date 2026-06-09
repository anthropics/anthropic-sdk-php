<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingParams\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Substitute the secret on any host the session's Environment network policy permits egress to. The Environment's network policy is the only boundary on where the secret can reach.
 *
 * @phpstan-type ManagedAgentsUnrestrictedCredentialNetworkingParamsShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsUnrestrictedCredentialNetworkingParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsUnrestrictedCredentialNetworkingParamsShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsUnrestrictedCredentialNetworkingParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsUnrestrictedCredentialNetworkingParams::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsUnrestrictedCredentialNetworkingParams)->withType(...)
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
    public static function with(Type|string $type): self
    {
        $self = new self;

        $self['type'] = $type;

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
