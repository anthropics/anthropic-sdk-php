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
 * @phpstan-import-type ManagedAgentsInjectionLocationUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationUpdateParams
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 *
 * @phpstan-type ManagedAgentsEnvironmentVariableUpdateParamsShape = array{
 *   type: Type|value-of<Type>,
 *   injectionLocation?: null|ManagedAgentsInjectionLocationUpdateParams|ManagedAgentsInjectionLocationUpdateParamsShape,
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
     * Updated injection location.
     */
    #[Optional('injection_location')]
    public ?ManagedAgentsInjectionLocationUpdateParams $injectionLocation;

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
     * @param ManagedAgentsInjectionLocationUpdateParams|ManagedAgentsInjectionLocationUpdateParamsShape|null $injectionLocation
     * @param ManagedAgentsCredentialNetworkingParamsShape|null $networking
     */
    public static function with(
        Type|string $type,
        ManagedAgentsInjectionLocationUpdateParams|array|null $injectionLocation = null,
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams|null $networking = null,
        ?string $secretValue = null,
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $injectionLocation && $self['injectionLocation'] = $injectionLocation;
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
     * Updated injection location.
     *
     * @param ManagedAgentsInjectionLocationUpdateParams|ManagedAgentsInjectionLocationUpdateParamsShape $injectionLocation
     */
    public function withInjectionLocation(
        ManagedAgentsInjectionLocationUpdateParams|array $injectionLocation
    ): self {
        $self = clone $this;
        $self['injectionLocation'] = $injectionLocation;

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
