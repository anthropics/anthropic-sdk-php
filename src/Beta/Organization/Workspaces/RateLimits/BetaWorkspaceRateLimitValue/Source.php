<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitValue;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitOrganizationSource;
use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitWorkspaceSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Where `value` comes from. `organization` values are listed only when `include_inherited` is `true`, and then `value` equals `org_limit`.
 *
 * @phpstan-import-type BetaWorkspaceRateLimitWorkspaceSourceShape from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitWorkspaceSource
 * @phpstan-import-type BetaWorkspaceRateLimitOrganizationSourceShape from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitOrganizationSource
 *
 * @phpstan-type SourceVariants = BetaWorkspaceRateLimitWorkspaceSource|BetaWorkspaceRateLimitOrganizationSource
 * @phpstan-type SourceShape = SourceVariants|BetaWorkspaceRateLimitWorkspaceSourceShape|BetaWorkspaceRateLimitOrganizationSourceShape
 */
final class Source implements ConverterSource
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
            'workspace' => BetaWorkspaceRateLimitWorkspaceSource::class,
            'organization' => BetaWorkspaceRateLimitOrganizationSource::class,
        ];
    }
}
