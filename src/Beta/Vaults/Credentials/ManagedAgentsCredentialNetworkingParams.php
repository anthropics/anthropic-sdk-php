<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsUnrestrictedCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingParams
 * @phpstan-import-type ManagedAgentsLimitedCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingParams
 *
 * @phpstan-type ManagedAgentsCredentialNetworkingParamsVariants = ManagedAgentsUnrestrictedCredentialNetworkingParams|ManagedAgentsLimitedCredentialNetworkingParams
 * @phpstan-type ManagedAgentsCredentialNetworkingParamsShape = ManagedAgentsCredentialNetworkingParamsVariants|ManagedAgentsUnrestrictedCredentialNetworkingParamsShape|ManagedAgentsLimitedCredentialNetworkingParamsShape
 */
final class ManagedAgentsCredentialNetworkingParams implements ConverterSource
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
            'unrestricted' => ManagedAgentsUnrestrictedCredentialNetworkingParams::class,
            'limited' => ManagedAgentsLimitedCredentialNetworkingParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<string>|null $allowedHosts
     *
     * @return ($type is Type::UNRESTRICTED|'unrestricted' ? ManagedAgentsUnrestrictedCredentialNetworkingParams : ($type is Type::LIMITED|'limited' ? ManagedAgentsLimitedCredentialNetworkingParams : ManagedAgentsUnrestrictedCredentialNetworkingParams|ManagedAgentsLimitedCredentialNetworkingParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $allowedHosts = null
    ): ManagedAgentsUnrestrictedCredentialNetworkingParams|ManagedAgentsLimitedCredentialNetworkingParams {
        return match ($type) {
            Type::UNRESTRICTED, 'unrestricted' => ManagedAgentsUnrestrictedCredentialNetworkingParams::with(
                type: 'unrestricted'
            ),
            Type::LIMITED, 'limited' => ManagedAgentsLimitedCredentialNetworkingParams::with(
                type: 'limited',
                allowedHosts: $allowedHosts ?? throw new \ArgumentCountError('$allowedHosts is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
