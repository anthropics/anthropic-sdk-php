<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits;

use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitBatchGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitFilesGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitModelGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitSkillsGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitTokenCountGroup;
use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimitWebSearchGroup;
use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit\Group;
use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit\GroupType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type GroupVariants from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit\Group
 * @phpstan-import-type GroupShape from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit\Group
 * @phpstan-import-type BetaWorkspaceRateLimitValueShape from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitValue
 *
 * @phpstan-type BetaWorkspaceRateLimitShape = array{
 *   group: GroupShape,
 *   groupType: GroupType|value-of<GroupType>,
 *   limits: list<BetaWorkspaceRateLimitValue|BetaWorkspaceRateLimitValueShape>,
 *   models: list<string>|null,
 *   rateLimitID: string,
 *   type: 'workspace_rate_limit',
 *   workspaceID: string,
 * }
 */
final class BetaWorkspaceRateLimit implements BaseModel
{
    /** @use SdkModel<BetaWorkspaceRateLimitShape> */
    use SdkModel;

    /**
     * Object type. Always `workspace_rate_limit` for workspace rate-limit entries.
     *
     * @var 'workspace_rate_limit' $type
     */
    #[Required(type: new ConstantOf('workspace_rate_limit'))]
    public string $type = 'workspace_rate_limit';

    /**
     * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
     *
     * @var GroupVariants $group
     */
    #[Required(union: Group::class)]
    public OrganizationRateLimitModelGroup|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group;

    /**
     * @deprecated Use `group.type` instead. `group_type` is still returned and always equals `group.type`.
     *
     * Deprecated: use `group.type` instead. The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`. Always equal to `group.type`.
     *
     * @var value-of<GroupType> $groupType
     */
    #[Required('group_type', enum: GroupType::class)]
    public string $groupType;

    /**
     * The limiter values overridden for this group in this workspace. Limiter types without a workspace override are omitted and inherit the organization value.
     *
     * @var list<BetaWorkspaceRateLimitValue> $limits
     */
    #[Required(list: BetaWorkspaceRateLimitValue::class)]
    public array $limits;

    /**
     * Model names this entry's limits apply to, including aliases. `null` when `group_type` is not `"model_group"`.
     *
     * @var list<string>|null $models
     */
    #[Required(list: 'string')]
    public ?array $models;

    /**
     * The `id` of the organization's RateLimit entry this override applies to.
     */
    #[Required('rate_limit_id')]
    public string $rateLimitID;

    /**
     * ID of the Workspace this override applies to.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new BetaWorkspaceRateLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWorkspaceRateLimit::with(
     *   group: ...,
     *   groupType: ...,
     *   limits: ...,
     *   models: ...,
     *   rateLimitID: ...,
     *   workspaceID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWorkspaceRateLimit)
     *   ->withGroup(...)
     *   ->withGroupType(...)
     *   ->withLimits(...)
     *   ->withModels(...)
     *   ->withRateLimitID(...)
     *   ->withWorkspaceID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param GroupShape $group
     * @param GroupType|value-of<GroupType> $groupType
     * @param list<BetaWorkspaceRateLimitValue|BetaWorkspaceRateLimitValueShape> $limits
     * @param list<string>|null $models
     */
    public static function with(
        OrganizationRateLimitModelGroup|array|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group,
        GroupType|string $groupType,
        array $limits,
        ?array $models,
        string $rateLimitID,
        string $workspaceID,
    ): self {
        $self = new self;

        $self['group'] = $group;
        $self['groupType'] = $groupType;
        $self['limits'] = $limits;
        $self['models'] = $models;
        $self['rateLimitID'] = $rateLimitID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The rate-limit group this entry's limits apply to. Its `type` equals `group_type`.
     *
     * @param GroupShape $group
     */
    public function withGroup(
        OrganizationRateLimitModelGroup|array|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group,
    ): self {
        $self = clone $this;
        $self['group'] = $group;

        return $self;
    }

    /**
     * Deprecated: use `group.type` instead. The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`. Always equal to `group.type`.
     *
     * @param GroupType|value-of<GroupType> $groupType
     */
    public function withGroupType(GroupType|string $groupType): self
    {
        $self = clone $this;
        $self['groupType'] = $groupType;

        return $self;
    }

    /**
     * The limiter values overridden for this group in this workspace. Limiter types without a workspace override are omitted and inherit the organization value.
     *
     * @param list<BetaWorkspaceRateLimitValue|BetaWorkspaceRateLimitValueShape> $limits
     */
    public function withLimits(array $limits): self
    {
        $self = clone $this;
        $self['limits'] = $limits;

        return $self;
    }

    /**
     * Model names this entry's limits apply to, including aliases. `null` when `group_type` is not `"model_group"`.
     *
     * @param list<string>|null $models
     */
    public function withModels(?array $models): self
    {
        $self = clone $this;
        $self['models'] = $models;

        return $self;
    }

    /**
     * The `id` of the organization's RateLimit entry this override applies to.
     */
    public function withRateLimitID(string $rateLimitID): self
    {
        $self = clone $this;
        $self['rateLimitID'] = $rateLimitID;

        return $self;
    }

    /**
     * Object type. Always `workspace_rate_limit` for workspace rate-limit entries.
     *
     * @param 'workspace_rate_limit' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the Workspace this override applies to.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
