<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit\GroupType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaWorkspaceRateLimitValueShape from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitValue
 *
 * @phpstan-type BetaWorkspaceRateLimitShape = array{
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
    #[Required]
    public string $type = 'workspace_rate_limit';

    /**
     * The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`.
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
     * The `id` of the RateLimit group this override applies to.
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
     *   groupType: ..., limits: ..., models: ..., rateLimitID: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWorkspaceRateLimit)
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
     * @param GroupType|value-of<GroupType> $groupType
     * @param list<BetaWorkspaceRateLimitValue|BetaWorkspaceRateLimitValueShape> $limits
     * @param list<string>|null $models
     */
    public static function with(
        GroupType|string $groupType,
        array $limits,
        ?array $models,
        string $rateLimitID,
        string $workspaceID,
    ): self {
        $self = new self;

        $self['groupType'] = $groupType;
        $self['limits'] = $limits;
        $self['models'] = $models;
        $self['rateLimitID'] = $rateLimitID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The kind of rate-limit group this entry represents. `model_group` entries apply to a family of models (listed in `models`); other values apply to an API-surface category and have `models` set to `null`.
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
     * The `id` of the RateLimit group this override applies to.
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
