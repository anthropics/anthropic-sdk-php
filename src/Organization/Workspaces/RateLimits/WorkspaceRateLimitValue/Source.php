<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitValue;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitOrganizationSource;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitWorkspaceSource;

/**
 * Where `value` comes from. `organization` values are listed only when `include_inherited` is `true`, and then `value` equals `org_limit`.
 *
 * @phpstan-import-type WorkspaceRateLimitWorkspaceSourceShape from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitWorkspaceSource
 * @phpstan-import-type WorkspaceRateLimitOrganizationSourceShape from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitOrganizationSource
 *
 * @phpstan-type SourceVariants = WorkspaceRateLimitWorkspaceSource|WorkspaceRateLimitOrganizationSource
 * @phpstan-type SourceShape = SourceVariants|WorkspaceRateLimitWorkspaceSourceShape|WorkspaceRateLimitOrganizationSourceShape
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
            'workspace' => WorkspaceRateLimitWorkspaceSource::class,
            'organization' => WorkspaceRateLimitOrganizationSource::class,
        ];
    }
}
