<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfig\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration for a specific agent tool.
 *
 * @phpstan-import-type BetaManagedAgentsBashToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfig
 * @phpstan-import-type BetaManagedAgentsEditToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsEditToolConfig
 * @phpstan-import-type BetaManagedAgentsReadToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsReadToolConfig
 * @phpstan-import-type BetaManagedAgentsWriteToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsWriteToolConfig
 * @phpstan-import-type BetaManagedAgentsGlobToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig
 * @phpstan-import-type BetaManagedAgentsGrepToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfig
 * @phpstan-import-type BetaManagedAgentsWebFetchToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfig
 * @phpstan-import-type BetaManagedAgentsWebSearchToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfig
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfig\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsEditToolConfig\PermissionPolicy as PermissionPolicyShape1
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsReadToolConfig\PermissionPolicy as PermissionPolicyShape2
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWriteToolConfig\PermissionPolicy as PermissionPolicyShape3
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig\PermissionPolicy as PermissionPolicyShape4
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfig\PermissionPolicy as PermissionPolicyShape5
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfig\PermissionPolicy as PermissionPolicyShape6
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfig\PermissionPolicy as PermissionPolicyShape7
 * @phpstan-import-type BetaManagedAgentsUserLocationShape from \Anthropic\Beta\Agents\BetaManagedAgentsUserLocation
 *
 * @phpstan-type BetaManagedAgentsAgentToolConfigVariants = BetaManagedAgentsBashToolConfig|BetaManagedAgentsEditToolConfig|BetaManagedAgentsReadToolConfig|BetaManagedAgentsWriteToolConfig|BetaManagedAgentsGlobToolConfig|BetaManagedAgentsGrepToolConfig|BetaManagedAgentsWebFetchToolConfig|BetaManagedAgentsWebSearchToolConfig
 * @phpstan-type BetaManagedAgentsAgentToolConfigShape = BetaManagedAgentsAgentToolConfigVariants|BetaManagedAgentsBashToolConfigShape|BetaManagedAgentsEditToolConfigShape|BetaManagedAgentsReadToolConfigShape|BetaManagedAgentsWriteToolConfigShape|BetaManagedAgentsGlobToolConfigShape|BetaManagedAgentsGrepToolConfigShape|BetaManagedAgentsWebFetchToolConfigShape|BetaManagedAgentsWebSearchToolConfigShape
 */
final class BetaManagedAgentsAgentToolConfig implements ConverterSource
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
            'bash' => BetaManagedAgentsBashToolConfig::class,
            'edit' => BetaManagedAgentsEditToolConfig::class,
            'read' => BetaManagedAgentsReadToolConfig::class,
            'write' => BetaManagedAgentsWriteToolConfig::class,
            'glob' => BetaManagedAgentsGlobToolConfig::class,
            'grep' => BetaManagedAgentsGrepToolConfig::class,
            'web_fetch' => BetaManagedAgentsWebFetchToolConfig::class,
            'web_search' => BetaManagedAgentsWebSearchToolConfig::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::BASH|'bash' ? PermissionPolicyShape : ($type is Type::EDIT|'edit' ? PermissionPolicyShape1 : ($type is Type::READ|'read' ? PermissionPolicyShape2 : ($type is Type::WRITE|'write' ? PermissionPolicyShape3 : ($type is Type::GLOB|'glob' ? PermissionPolicyShape4 : ($type is Type::GREP|'grep' ? PermissionPolicyShape5 : ($type is Type::WEB_FETCH|'web_fetch' ? PermissionPolicyShape6 : PermissionPolicyShape7))))))) $permissionPolicy
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     * @param BetaManagedAgentsUserLocation|BetaManagedAgentsUserLocationShape|null $userLocation
     *
     * @return ($type is Type::BASH|'bash' ? BetaManagedAgentsBashToolConfig : ($type is Type::EDIT|'edit' ? BetaManagedAgentsEditToolConfig : ($type is Type::READ|'read' ? BetaManagedAgentsReadToolConfig : ($type is Type::WRITE|'write' ? BetaManagedAgentsWriteToolConfig : ($type is Type::GLOB|'glob' ? BetaManagedAgentsGlobToolConfig : ($type is Type::GREP|'grep' ? BetaManagedAgentsGrepToolConfig : ($type is Type::WEB_FETCH|'web_fetch' ? BetaManagedAgentsWebFetchToolConfig : ($type is Type::WEB_SEARCH|'web_search' ? BetaManagedAgentsWebSearchToolConfig : BetaManagedAgentsBashToolConfig|BetaManagedAgentsEditToolConfig|BetaManagedAgentsReadToolConfig|BetaManagedAgentsWriteToolConfig|BetaManagedAgentsGlobToolConfig|BetaManagedAgentsGrepToolConfig|BetaManagedAgentsWebFetchToolConfig|BetaManagedAgentsWebSearchToolConfig))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        bool $enabled,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|BetaManagedAgentsAutoPolicy $permissionPolicy,
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?int $maxContentTokens = null,
        BetaManagedAgentsUserLocation|array|null $userLocation = null,
    ): BetaManagedAgentsBashToolConfig|BetaManagedAgentsEditToolConfig|BetaManagedAgentsReadToolConfig|BetaManagedAgentsWriteToolConfig|BetaManagedAgentsGlobToolConfig|BetaManagedAgentsGrepToolConfig|BetaManagedAgentsWebFetchToolConfig|BetaManagedAgentsWebSearchToolConfig {
        return match ($type) {
            Type::BASH, 'bash' => BetaManagedAgentsBashToolConfig::with(
                enabled: $enabled,
                permissionPolicy: $permissionPolicy
            ),
            Type::EDIT, 'edit' => BetaManagedAgentsEditToolConfig::with(
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::READ, 'read' => BetaManagedAgentsReadToolConfig::with(
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::WRITE, 'write' => BetaManagedAgentsWriteToolConfig::with(
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::GLOB, 'glob' => BetaManagedAgentsGlobToolConfig::with(
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::GREP, 'grep' => BetaManagedAgentsGrepToolConfig::with(
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::WEB_FETCH, 'web_fetch' => BetaManagedAgentsWebFetchToolConfig::with(
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
                allowedDomains: $allowedDomains,
                blockedDomains: $blockedDomains,
                maxContentTokens: $maxContentTokens,
            ),
            Type::WEB_SEARCH, 'web_search' => BetaManagedAgentsWebSearchToolConfig::with(
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
                allowedDomains: $allowedDomains,
                blockedDomains: $blockedDomains,
                userLocation: $userLocation,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
