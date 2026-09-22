<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingResponse;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Outbound hosts the secret value is substituted on.
 *
 * @phpstan-import-type ManagedAgentsUnrestrictedCredentialNetworkingResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingResponse
 * @phpstan-import-type ManagedAgentsLimitedCredentialNetworkingResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingResponse
 *
 * @phpstan-type NetworkingVariants = ManagedAgentsUnrestrictedCredentialNetworkingResponse|ManagedAgentsLimitedCredentialNetworkingResponse
 * @phpstan-type NetworkingShape = NetworkingVariants|ManagedAgentsUnrestrictedCredentialNetworkingResponseShape|ManagedAgentsLimitedCredentialNetworkingResponseShape
 */
final class Networking implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'unrestricted' => ManagedAgentsUnrestrictedCredentialNetworkingResponse::class,
            'limited' => ManagedAgentsLimitedCredentialNetworkingResponse::class,
        ];
    }
}
