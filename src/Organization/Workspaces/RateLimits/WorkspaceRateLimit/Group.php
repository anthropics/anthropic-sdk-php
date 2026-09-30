<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\RateLimits\OrganizationRateLimitBatchGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitFilesGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitModelGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitSkillsGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitTokenCountGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitWebSearchGroup;

/**
 * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
 *
 * @phpstan-import-type OrganizationRateLimitModelGroupShape from \Anthropic\Organization\RateLimits\OrganizationRateLimitModelGroup
 * @phpstan-import-type OrganizationRateLimitBatchGroupShape from \Anthropic\Organization\RateLimits\OrganizationRateLimitBatchGroup
 * @phpstan-import-type OrganizationRateLimitTokenCountGroupShape from \Anthropic\Organization\RateLimits\OrganizationRateLimitTokenCountGroup
 * @phpstan-import-type OrganizationRateLimitFilesGroupShape from \Anthropic\Organization\RateLimits\OrganizationRateLimitFilesGroup
 * @phpstan-import-type OrganizationRateLimitSkillsGroupShape from \Anthropic\Organization\RateLimits\OrganizationRateLimitSkillsGroup
 * @phpstan-import-type OrganizationRateLimitWebSearchGroupShape from \Anthropic\Organization\RateLimits\OrganizationRateLimitWebSearchGroup
 *
 * @phpstan-type GroupVariants = OrganizationRateLimitModelGroup|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup
 * @phpstan-type GroupShape = GroupVariants|OrganizationRateLimitModelGroupShape|OrganizationRateLimitBatchGroupShape|OrganizationRateLimitTokenCountGroupShape|OrganizationRateLimitFilesGroupShape|OrganizationRateLimitSkillsGroupShape|OrganizationRateLimitWebSearchGroupShape
 */
final class Group implements ConverterSource
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
            'model_group' => OrganizationRateLimitModelGroup::class,
            'batch' => OrganizationRateLimitBatchGroup::class,
            'token_count' => OrganizationRateLimitTokenCountGroup::class,
            'files' => OrganizationRateLimitFilesGroup::class,
            'skills' => OrganizationRateLimitSkillsGroup::class,
            'web_search' => OrganizationRateLimitWebSearchGroup::class,
        ];
    }
}
