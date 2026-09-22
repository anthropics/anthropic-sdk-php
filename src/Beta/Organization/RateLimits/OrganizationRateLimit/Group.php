<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit;

use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitBatchGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitFilesGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitModelGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitSkillsGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitTokenCountGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitWebSearchGroup;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
 *
 * @phpstan-import-type OrganizationRateLimitModelGroupShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitModelGroup
 * @phpstan-import-type OrganizationRateLimitBatchGroupShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitBatchGroup
 * @phpstan-import-type OrganizationRateLimitTokenCountGroupShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitTokenCountGroup
 * @phpstan-import-type OrganizationRateLimitFilesGroupShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitFilesGroup
 * @phpstan-import-type OrganizationRateLimitSkillsGroupShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitSkillsGroup
 * @phpstan-import-type OrganizationRateLimitWebSearchGroupShape from \Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitWebSearchGroup
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
