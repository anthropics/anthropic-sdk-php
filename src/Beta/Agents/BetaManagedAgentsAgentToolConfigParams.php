<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration override for a specific tool within a toolset.
 *
 * @phpstan-import-type BetaManagedAgentsBashToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfigParams
 * @phpstan-import-type BetaManagedAgentsEditToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsEditToolConfigParams
 * @phpstan-import-type BetaManagedAgentsReadToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsReadToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWriteToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWriteToolConfigParams
 * @phpstan-import-type BetaManagedAgentsGlobToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfigParams
 * @phpstan-import-type BetaManagedAgentsGrepToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWebFetchToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWebSearchToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfigParams
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfigParams\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsEditToolConfigParams\PermissionPolicy as PermissionPolicyShape1
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsReadToolConfigParams\PermissionPolicy as PermissionPolicyShape2
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWriteToolConfigParams\PermissionPolicy as PermissionPolicyShape3
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfigParams\PermissionPolicy as PermissionPolicyShape4
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfigParams\PermissionPolicy as PermissionPolicyShape5
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfigParams\PermissionPolicy as PermissionPolicyShape6
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfigParams\PermissionPolicy as PermissionPolicyShape7
 * @phpstan-import-type BetaManagedAgentsUserLocationShape from \Anthropic\Beta\Agents\BetaManagedAgentsUserLocation
 *
 * @phpstan-type BetaManagedAgentsAgentToolConfigParamsVariants = BetaManagedAgentsBashToolConfigParams|BetaManagedAgentsEditToolConfigParams|BetaManagedAgentsReadToolConfigParams|BetaManagedAgentsWriteToolConfigParams|BetaManagedAgentsGlobToolConfigParams|BetaManagedAgentsGrepToolConfigParams|BetaManagedAgentsWebFetchToolConfigParams|BetaManagedAgentsWebSearchToolConfigParams
 * @phpstan-type BetaManagedAgentsAgentToolConfigParamsShape = BetaManagedAgentsAgentToolConfigParamsVariants|BetaManagedAgentsBashToolConfigParamsShape|BetaManagedAgentsEditToolConfigParamsShape|BetaManagedAgentsReadToolConfigParamsShape|BetaManagedAgentsWriteToolConfigParamsShape|BetaManagedAgentsGlobToolConfigParamsShape|BetaManagedAgentsGrepToolConfigParamsShape|BetaManagedAgentsWebFetchToolConfigParamsShape|BetaManagedAgentsWebSearchToolConfigParamsShape
 */
final class BetaManagedAgentsAgentToolConfigParams implements ConverterSource
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
            'bash' => BetaManagedAgentsBashToolConfigParams::class,
            'edit' => BetaManagedAgentsEditToolConfigParams::class,
            'read' => BetaManagedAgentsReadToolConfigParams::class,
            'write' => BetaManagedAgentsWriteToolConfigParams::class,
            'glob' => BetaManagedAgentsGlobToolConfigParams::class,
            'grep' => BetaManagedAgentsGrepToolConfigParams::class,
            'web_fetch' => BetaManagedAgentsWebFetchToolConfigParams::class,
            'web_search' => BetaManagedAgentsWebSearchToolConfigParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::BASH|'bash' ? PermissionPolicyShape|null : ($type is Type::EDIT|'edit' ? PermissionPolicyShape1|null : ($type is Type::READ|'read' ? PermissionPolicyShape2|null : ($type is Type::WRITE|'write' ? PermissionPolicyShape3|null : ($type is Type::GLOB|'glob' ? PermissionPolicyShape4|null : ($type is Type::GREP|'grep' ? PermissionPolicyShape5|null : ($type is Type::WEB_FETCH|'web_fetch' ? PermissionPolicyShape6|null : PermissionPolicyShape7|null))))))) $permissionPolicy
     * @param list<string>|null $allowedDomains
     * @param list<string>|null $blockedDomains
     * @param BetaManagedAgentsUserLocation|BetaManagedAgentsUserLocationShape|null $userLocation
     *
     * @return ($type is Type::BASH|'bash' ? BetaManagedAgentsBashToolConfigParams : ($type is Type::EDIT|'edit' ? BetaManagedAgentsEditToolConfigParams : ($type is Type::READ|'read' ? BetaManagedAgentsReadToolConfigParams : ($type is Type::WRITE|'write' ? BetaManagedAgentsWriteToolConfigParams : ($type is Type::GLOB|'glob' ? BetaManagedAgentsGlobToolConfigParams : ($type is Type::GREP|'grep' ? BetaManagedAgentsGrepToolConfigParams : ($type is Type::WEB_FETCH|'web_fetch' ? BetaManagedAgentsWebFetchToolConfigParams : ($type is Type::WEB_SEARCH|'web_search' ? BetaManagedAgentsWebSearchToolConfigParams : BetaManagedAgentsBashToolConfigParams|BetaManagedAgentsEditToolConfigParams|BetaManagedAgentsReadToolConfigParams|BetaManagedAgentsWriteToolConfigParams|BetaManagedAgentsGlobToolConfigParams|BetaManagedAgentsGrepToolConfigParams|BetaManagedAgentsWebFetchToolConfigParams|BetaManagedAgentsWebSearchToolConfigParams))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?bool $enabled = null,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|BetaManagedAgentsAutoPolicy|null $permissionPolicy = null,
        ?array $allowedDomains = null,
        ?array $blockedDomains = null,
        ?int $maxContentTokens = null,
        BetaManagedAgentsUserLocation|array|null $userLocation = null,
    ): BetaManagedAgentsBashToolConfigParams|BetaManagedAgentsEditToolConfigParams|BetaManagedAgentsReadToolConfigParams|BetaManagedAgentsWriteToolConfigParams|BetaManagedAgentsGlobToolConfigParams|BetaManagedAgentsGrepToolConfigParams|BetaManagedAgentsWebFetchToolConfigParams|BetaManagedAgentsWebSearchToolConfigParams {
        return match ($type) {
            Type::BASH, 'bash' => BetaManagedAgentsBashToolConfigParams::with(
                type: 'bash',
                enabled: $enabled,
                permissionPolicy: $permissionPolicy
            ),
            Type::EDIT, 'edit' => BetaManagedAgentsEditToolConfigParams::with(
                type: 'edit',
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::READ, 'read' => BetaManagedAgentsReadToolConfigParams::with(
                type: 'read',
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::WRITE, 'write' => BetaManagedAgentsWriteToolConfigParams::with(
                type: 'write',
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::GLOB, 'glob' => BetaManagedAgentsGlobToolConfigParams::with(
                type: 'glob',
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::GREP, 'grep' => BetaManagedAgentsGrepToolConfigParams::with(
                type: 'grep',
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::WEB_FETCH, 'web_fetch' => BetaManagedAgentsWebFetchToolConfigParams::with(
                type: 'web_fetch',
                allowedDomains: $allowedDomains,
                blockedDomains: $blockedDomains,
                enabled: $enabled,
                maxContentTokens: $maxContentTokens,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
            ),
            Type::WEB_SEARCH, 'web_search' => BetaManagedAgentsWebSearchToolConfigParams::with(
                type: 'web_search',
                allowedDomains: $allowedDomains,
                blockedDomains: $blockedDomains,
                enabled: $enabled,
                // @phpstan-ignore argument.type
                permissionPolicy: $permissionPolicy,
                userLocation: $userLocation,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
