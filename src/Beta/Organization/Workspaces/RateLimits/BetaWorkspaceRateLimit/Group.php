<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;

use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitBatchGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitFilesGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitModelGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitSkillsGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitTokenCountGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitWebSearchGroup;
use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit\Group\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::MODEL_GROUP|'model_group' ? OrganizationRateLimitModelGroup : ($type is Type::BATCH|'batch' ? OrganizationRateLimitBatchGroup : ($type is Type::TOKEN_COUNT|'token_count' ? OrganizationRateLimitTokenCountGroup : ($type is Type::FILES|'files' ? OrganizationRateLimitFilesGroup : ($type is Type::SKILLS|'skills' ? OrganizationRateLimitSkillsGroup : ($type is Type::WEB_SEARCH|'web_search' ? OrganizationRateLimitWebSearchGroup : OrganizationRateLimitModelGroup|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $id,
        ?string $displayName = null
    ): OrganizationRateLimitModelGroup|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup {
        return match ($type) {
            Type::MODEL_GROUP, 'model_group' => OrganizationRateLimitModelGroup::with(
                id: $id,
                displayName: $displayName ?? throw new \ArgumentCountError('$displayName is required'),
            ),
            Type::BATCH, 'batch' => OrganizationRateLimitBatchGroup::with(id: $id),
            Type::TOKEN_COUNT, 'token_count' => OrganizationRateLimitTokenCountGroup::with(
                id: $id
            ),
            Type::FILES, 'files' => OrganizationRateLimitFilesGroup::with(id: $id),
            Type::SKILLS, 'skills' => OrganizationRateLimitSkillsGroup::with(
                id: $id
            ),
            Type::WEB_SEARCH, 'web_search' => OrganizationRateLimitWebSearchGroup::with(
                id: $id
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
