<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse\Networking;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Environment variable credential details. The secret value is never returned.
 *
 * @phpstan-import-type ManagedAgentsInjectionLocationResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationResponse
 * @phpstan-import-type NetworkingShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse\Networking
 * @phpstan-import-type NetworkingVariants from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse\Networking
 *
 * @phpstan-type ManagedAgentsEnvironmentVariableAuthResponseShape = array{
 *   injectionLocation: ManagedAgentsInjectionLocationResponse|ManagedAgentsInjectionLocationResponseShape,
 *   networking: NetworkingShape,
 *   secretName: string,
 *   type: 'environment_variable',
 * }
 */
final class ManagedAgentsEnvironmentVariableAuthResponse implements BaseModel
{
    /** @use SdkModel<ManagedAgentsEnvironmentVariableAuthResponseShape> */
    use SdkModel;

    /** @var 'environment_variable' $type */
    #[Required(type: new ConstantOf('environment_variable'))]
    public string $type = 'environment_variable';

    /**
     * Where in the outbound request the secret value is substituted.
     */
    #[Required('injection_location')]
    public ManagedAgentsInjectionLocationResponse $injectionLocation;

    /**
     * Outbound hosts the secret value is substituted on.
     *
     * @var NetworkingVariants $networking
     */
    #[Required(union: Networking::class)]
    public ManagedAgentsUnrestrictedCredentialNetworkingResponse|ManagedAgentsLimitedCredentialNetworkingResponse $networking;

    /**
     * Name of the environment variable.
     */
    #[Required('secret_name')]
    public string $secretName;

    /**
     * `new ManagedAgentsEnvironmentVariableAuthResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsEnvironmentVariableAuthResponse::with(
     *   injectionLocation: ..., networking: ..., secretName: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsEnvironmentVariableAuthResponse())
     *   ->withInjectionLocation(...)
     *   ->withNetworking(...)
     *   ->withSecretName(...)
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
     * @param ManagedAgentsInjectionLocationResponse|ManagedAgentsInjectionLocationResponseShape $injectionLocation
     * @param NetworkingShape $networking
     */
    public static function with(
        ManagedAgentsInjectionLocationResponse|array $injectionLocation,
        ManagedAgentsUnrestrictedCredentialNetworkingResponse|array|ManagedAgentsLimitedCredentialNetworkingResponse $networking,
        string $secretName,
    ): self {
        $self = new self;

        $self['injectionLocation'] = $injectionLocation;
        $self['networking'] = $networking;
        $self['secretName'] = $secretName;

        return $self;
    }

    /**
     * Where in the outbound request the secret value is substituted.
     *
     * @param ManagedAgentsInjectionLocationResponse|ManagedAgentsInjectionLocationResponseShape $injectionLocation
     */
    public function withInjectionLocation(
        ManagedAgentsInjectionLocationResponse|array $injectionLocation
    ): self {
        $self = clone $this;
        $self['injectionLocation'] = $injectionLocation;

        return $self;
    }

    /**
     * Outbound hosts the secret value is substituted on.
     *
     * @param NetworkingShape $networking
     */
    public function withNetworking(
        ManagedAgentsUnrestrictedCredentialNetworkingResponse|array|ManagedAgentsLimitedCredentialNetworkingResponse $networking,
    ): self {
        $self = clone $this;
        $self['networking'] = $networking;

        return $self;
    }

    /**
     * Name of the environment variable.
     */
    public function withSecretName(string $secretName): self
    {
        $self = clone $this;
        $self['secretName'] = $secretName;

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
}
