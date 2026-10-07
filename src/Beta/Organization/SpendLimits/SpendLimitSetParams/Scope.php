<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams;

use Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitSetParams\Scope\Type;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitUserScope;
use Anthropic\Beta\Organization\SpendLimits\SpendLimitWorkspaceScope;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * What the limit applies to. Claude Enterprise organizations set `user` limits. Claude Console organizations set `organization` and `workspace` limits. Any other combination returns 400. Setting `organization` and `workspace` limits through the API is in an early access preview. To request access, contact your Anthropic account team.
 *
 * @phpstan-import-type SpendLimitUserScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitUserScope
 * @phpstan-import-type SpendLimitOrganizationScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitOrganizationScope
 * @phpstan-import-type SpendLimitWorkspaceScopeShape from \Anthropic\Beta\Organization\SpendLimits\SpendLimitWorkspaceScope
 *
 * @phpstan-type ScopeVariants = SpendLimitUserScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope
 * @phpstan-type ScopeShape = ScopeVariants|SpendLimitUserScopeShape|SpendLimitOrganizationScopeShape|SpendLimitWorkspaceScopeShape
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
            'organization' => SpendLimitOrganizationScope::class,
            'workspace' => SpendLimitWorkspaceScope::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::USER|'user' ? SpendLimitUserScope : ($type is Type::ORGANIZATION|'organization' ? SpendLimitOrganizationScope : ($type is Type::WORKSPACE|'workspace' ? SpendLimitWorkspaceScope : SpendLimitUserScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $userID = null,
        ?string $workspaceID = null
    ): SpendLimitUserScope|SpendLimitOrganizationScope|SpendLimitWorkspaceScope {
        return match ($type) {
            Type::USER, 'user' => SpendLimitUserScope::with(
                userID: $userID ?? throw new \ArgumentCountError('$userID is required'),
            ),
            Type::ORGANIZATION, 'organization' => SpendLimitOrganizationScope::with(
            ),
            Type::WORKSPACE, 'workspace' => SpendLimitWorkspaceScope::with(
                workspaceID: $workspaceID ?? throw new \ArgumentCountError('$workspaceID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
