<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse\Networking\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<string>|null $allowedHosts
     *
     * @return ($type is Type::UNRESTRICTED|'unrestricted' ? ManagedAgentsUnrestrictedCredentialNetworkingResponse : ($type is Type::LIMITED|'limited' ? ManagedAgentsLimitedCredentialNetworkingResponse : ManagedAgentsUnrestrictedCredentialNetworkingResponse|ManagedAgentsLimitedCredentialNetworkingResponse))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $allowedHosts = null,
    ): ManagedAgentsUnrestrictedCredentialNetworkingResponse|ManagedAgentsLimitedCredentialNetworkingResponse {
        return match ($type) {
            Type::UNRESTRICTED, 'unrestricted' => ManagedAgentsUnrestrictedCredentialNetworkingResponse::with(
                type: 'unrestricted'
            ),
            Type::LIMITED, 'limited' => ManagedAgentsLimitedCredentialNetworkingResponse::with(
                type: 'limited',
                allowedHosts: $allowedHosts ?? throw new \ArgumentCountError('$allowedHosts is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
