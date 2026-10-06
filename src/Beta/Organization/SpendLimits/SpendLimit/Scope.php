<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\SpendLimit;

use Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationServiceScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitRBACGroupScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitSeatTierScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitUserScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitWorkspaceScope;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * What the limit applies to. A tagged union on `type`; each variant carries the identifier for its scope.
 *
 * @phpstan-import-type SpendLimitUserScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitUserScope
 * @phpstan-import-type SpendLimitSeatTierScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitSeatTierScope
 * @phpstan-import-type SpendLimitRBACGroupScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitRBACGroupScope
 * @phpstan-import-type SpendLimitOrganizationServiceScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationServiceScope
 * @phpstan-import-type SpendLimitOrganizationScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationScope
 * @phpstan-import-type SpendLimitWorkspaceScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitWorkspaceScope
 *
 * @phpstan-type ScopeVariants = SpendLimitUserScope|SpendLimitSeatTierScope|SpendLimitRBACGroupScope|SpendLimitOrganizationServiceScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope
 * @phpstan-type ScopeShape = ScopeVariants|SpendLimitUserScopeShape|SpendLimitSeatTierScopeShape|SpendLimitRBACGroupScopeShape|SpendLimitOrganizationServiceScopeShape|SpendLimitOrganizationScopeShape|SpendLimitWorkspaceScopeShape
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
        ];
    }
}
