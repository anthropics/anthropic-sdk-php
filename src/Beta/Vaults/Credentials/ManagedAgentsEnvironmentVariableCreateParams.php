<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Parameters for creating an environment variable credential.
 *
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 * @phpstan-import-type ManagedAgentsInjectionLocationParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationParams
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsVariants from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 *
 * @phpstan-type ManagedAgentsEnvironmentVariableCreateParamsShape = array{
 *   networking: ManagedAgentsCredentialNetworkingParamsShape,
 *   secretName: string,
 *   secretValue: string,
 *   type: 'environment_variable',
 *   injectionLocation?: null|ManagedAgentsInjectionLocationParams|ManagedAgentsInjectionLocationParamsShape,
 * }
 */
final class ManagedAgentsEnvironmentVariableCreateParams implements BaseModel
{
    /** @use SdkModel<ManagedAgentsEnvironmentVariableCreateParamsShape> */
    use SdkModel;

    /** @var 'environment_variable' $type */
    #[Required(type: new ConstantOf('environment_variable'))]
    public string $type = 'environment_variable';

    /**
     * Outbound hosts the secret value is substituted on.
     *
     * @var ManagedAgentsCredentialNetworkingParamsVariants $networking
     */
    #[Required(union: ManagedAgentsCredentialNetworkingParams::class)]
    public ManagedAgentsUnrestrictedCredentialNetworkingParams|ManagedAgentsLimitedCredentialNetworkingParams $networking;

    /**
     * Name of the environment variable. Immutable after create.
     */
    #[Required('secret_name')]
    public string $secretName;

    /**
     * The secret to substitute into the agent's outbound requests. It's write-only and never returned in responses.
     */
    #[Required('secret_value')]
    public string $secretValue;

    /**
     * Where in the outbound request the secret value may be substituted.
     */
    #[Optional('injection_location')]
    public ?ManagedAgentsInjectionLocationParams $injectionLocation;

    /**
     * `new ManagedAgentsEnvironmentVariableCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsEnvironmentVariableCreateParams::with(
     *   networking: ..., secretName: ..., secretValue: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsEnvironmentVariableCreateParams())
     *   ->withNetworking(...)
     *   ->withSecretName(...)
     *   ->withSecretValue(...)
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
     * @param ManagedAgentsCredentialNetworkingParamsShape $networking
     * @param ManagedAgentsInjectionLocationParams|ManagedAgentsInjectionLocationParamsShape|null $injectionLocation
     */
    public static function with(
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams $networking,
        string $secretName,
        string $secretValue,
        ManagedAgentsInjectionLocationParams|array|null $injectionLocation = null,
    ): self {
        $self = new self;

        $self['networking'] = $networking;
        $self['secretName'] = $secretName;
        $self['secretValue'] = $secretValue;

        null !== $injectionLocation && $self['injectionLocation'] = $injectionLocation;

        return $self;
    }

    /**
     * Outbound hosts the secret value is substituted on.
     *
     * @param ManagedAgentsCredentialNetworkingParamsShape $networking
     */
    public function withNetworking(
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams $networking,
    ): self {
        $self = clone $this;
        $self['networking'] = $networking;

        return $self;
    }

    /**
     * Name of the environment variable. Immutable after create.
     */
    public function withSecretName(string $secretName): self
    {
        $self = clone $this;
        $self['secretName'] = $secretName;

        return $self;
    }

    /**
     * The secret to substitute into the agent's outbound requests. It's write-only and never returned in responses.
     */
    public function withSecretValue(string $secretValue): self
    {
        $self = clone $this;
        $self['secretValue'] = $secretValue;

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
     * Where in the outbound request the secret value may be substituted.
     *
     * @param ManagedAgentsInjectionLocationParams|ManagedAgentsInjectionLocationParamsShape $injectionLocation
     */
    public function withInjectionLocation(
        ManagedAgentsInjectionLocationParams|array $injectionLocation
    ): self {
        $self = clone $this;
        $self['injectionLocation'] = $injectionLocation;

        return $self;
    }
}
