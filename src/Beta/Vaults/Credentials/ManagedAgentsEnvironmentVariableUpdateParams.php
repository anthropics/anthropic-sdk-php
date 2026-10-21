<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for updating an environment variable credential. `secret_name` is immutable.
 *
 * @phpstan-import-type ManagedAgentsInjectionLocationUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationUpdateParams
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsVariants from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 *
 * @phpstan-type ManagedAgentsEnvironmentVariableUpdateParamsShape = array{
 *   type: 'environment_variable',
 *   injectionLocation?: null|ManagedAgentsInjectionLocationUpdateParams|ManagedAgentsInjectionLocationUpdateParamsShape,
 *   networking?: ManagedAgentsCredentialNetworkingParamsShape|null,
 *   secretValue?: string|null,
 * }
 */
final class ManagedAgentsEnvironmentVariableUpdateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsEnvironmentVariableUpdateParamsShape> */
    use SdkModel;

    /** @var 'environment_variable' $type */
    #[Required(type: new ConstantOf('environment_variable'))]
    public string $type = 'environment_variable';

    /**
     * Updated injection location.
     */
    #[Optional('injection_location')]
    public ?ManagedAgentsInjectionLocationUpdateParams $injectionLocation;

    /**
     * The new networking scope, which replaces the stored one as a whole.
     *
     * @var ManagedAgentsCredentialNetworkingParamsVariants|null $networking
     */
    #[Optional(
        union: ManagedAgentsCredentialNetworkingParams::class,
        nullable: true
    )]
    public ManagedAgentsUnrestrictedCredentialNetworkingParams|ManagedAgentsLimitedCredentialNetworkingParams|null $networking;

    /**
     * The new secret value to replace the stored one.
     */
    #[Optional('secret_value', nullable: true)]
    public ?string $secretValue;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ManagedAgentsInjectionLocationUpdateParams|ManagedAgentsInjectionLocationUpdateParamsShape|null $injectionLocation
     * @param ManagedAgentsCredentialNetworkingParamsShape|null $networking
     */
    public static function with(
        ManagedAgentsInjectionLocationUpdateParams|array|null $injectionLocation = null,
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams|null $networking = null,
        ?string $secretValue = null,
    ): self {
        $self = new self;

        null !== $injectionLocation && $self['injectionLocation'] = $injectionLocation;
        null !== $networking && $self['networking'] = $networking;
        null !== $secretValue && $self['secretValue'] = $secretValue;

        return $self;
    }

    /**
     * @param 'environment_variable' $type
     */
    public function withType(string $type): self
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
     * The new networking scope, which replaces the stored one as a whole.
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
     * The new secret value to replace the stored one.
     */
    public function withSecretValue(?string $secretValue): self
    {
        $self = clone $this;
        $self['secretValue'] = $secretValue;

        return $self;
    }
}
