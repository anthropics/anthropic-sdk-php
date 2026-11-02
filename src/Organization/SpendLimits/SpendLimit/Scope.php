<?php

declare(strict_types=1);

namespace Anthropic\Organization\SpendLimits\SpendLimit;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\SpendLimits\SpendLimitOrganizationScope;
use Anthropic\Organization\SpendLimits\SpendLimitOrganizationServiceScope;
use Anthropic\Organization\SpendLimits\SpendLimitRBACGroupScope;
use Anthropic\Organization\SpendLimits\SpendLimitSeatTierScope;
use Anthropic\Organization\SpendLimits\SpendLimitUsageTierScope;
use Anthropic\Organization\SpendLimits\SpendLimitUserScope;
use Anthropic\Organization\SpendLimits\SpendLimitWorkspaceScope;

/**
 * What the limit applies to. A tagged union on `type`; each variant carries the identifier for its scope.
 *
 * @phpstan-import-type SpendLimitUserScopeShape from \Anthropic\Organization\SpendLimits\SpendLimitUserScope
 * @phpstan-import-type SpendLimitSeatTierScopeShape from \Anthropic\Organization\SpendLimits\SpendLimitSeatTierScope
 * @phpstan-import-type SpendLimitRBACGroupScopeShape from \Anthropic\Organization\SpendLimits\SpendLimitRBACGroupScope
 * @phpstan-import-type SpendLimitOrganizationServiceScopeShape from \Anthropic\Organization\SpendLimits\SpendLimitOrganizationServiceScope
 * @phpstan-import-type SpendLimitOrganizationScopeShape from \Anthropic\Organization\SpendLimits\SpendLimitOrganizationScope
 * @phpstan-import-type SpendLimitWorkspaceScopeShape from \Anthropic\Organization\SpendLimits\SpendLimitWorkspaceScope
 * @phpstan-import-type SpendLimitUsageTierScopeShape from \Anthropic\Organization\SpendLimits\SpendLimitUsageTierScope
 *
 * @phpstan-type ScopeVariants = SpendLimitUserScope|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope|SpendLimitUsageTierScope
 * @phpstan-type ScopeShape = ScopeVariants|SpendLimitUserScopeShape|SpendLimitSeatTierScopeShape|SpendLimitRBACGroupScopeShape|SpendLimitOrganizationServiceScopeShape|SpendLimitOrganizationScopeShape|SpendLimitWorkspaceScopeShape|SpendLimitUsageTierScopeShape
 */
final class Scope implements ConverterSource
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
            'user' => SpendLimitUserScope::class,
            'seat_tier' => SpendLimitSeatTierScope::class,
            'rbac_group' => SpendLimitRBACGroupScope::class,
            'organization_service' => SpendLimitOrganizationServiceScope::class,
            'organization' => SpendLimitOrganizationScope::class,
            'workspace' => SpendLimitWorkspaceScope::class,
            'usage_tier' => SpendLimitUsageTierScope::class,
        ];
    }
}
