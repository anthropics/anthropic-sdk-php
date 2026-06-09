<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableUpdateParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Parameters for updating an environment variable credential. `secret_name` is immutable.
 *
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsVariants from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 *
 * @phpstan-type ManagedAgentsEnvironmentVariableUpdateParamsShape = array{
 *   type: Type|value-of<Type>,
 *   networking?: ManagedAgentsCredentialNetworkingParamsShape|null,
 *   secretValue?: string|null,
 * }
 */
final class ManagedAgentsEnvironmentVariableUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsEnvironmentVariableUpdateParamsShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Updated networking scope. Full replacement.
     *
     * @var ManagedAgentsCredentialNetworkingParamsVariants|null $networking
     */
    #[Optional(
        union: ManagedAgentsCredentialNetworkingParams::class,
        nullable: true
    )]
    public ManagedAgentsUnrestrictedCredentialNetworkingParams|ManagedAgentsLimitedCredentialNetworkingParams|null $networking;

    /**
     * Updated secret value.
     */
    #[Optional('secret_value', nullable: true)]
    public ?string $secretValue;

    /**
     * `new ManagedAgentsEnvironmentVariableUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsEnvironmentVariableUpdateParams::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsEnvironmentVariableUpdateParams)->withType(...)
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
     * @param ManagedAgentsCredentialNetworkingParamsShape|null $networking
     */
    public static function with(
        Type|string $type,
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams|null $networking = null,
        ?string $secretValue = null,
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $networking && $self['networking'] = $networking;
        null !== $secretValue && $self['secretValue'] = $secretValue;

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
     * Updated networking scope. Full replacement.
     *
     * @param ManagedAgentsCredentialNetworkingParamsShape|null $networking
     */
    public function withNetworking(
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams|null $networking,
    ): self {
        $self = clone $this;
        $self['networking'] = $networking;

        return $self;
    }

    /**
     * Updated secret value.
     */
    public function withSecretValue(?string $secretValue): self
    {
        $self = clone $this;
        $self['secretValue'] = $secretValue;

        return $self;
    }
}
