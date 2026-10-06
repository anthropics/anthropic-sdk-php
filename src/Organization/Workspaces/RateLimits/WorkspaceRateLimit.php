<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\RateLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Organization\RateLimits\OrganizationRateLimitBatchGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitFilesGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitModelGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitSkillsGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitTokenCountGroup;
use Anthropic\Organization\RateLimits\OrganizationRateLimitWebSearchGroup;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit\Group;

/**
 * @phpstan-import-type GroupShape from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit\Group
 * @phpstan-import-type WorkspaceRateLimitValueShape from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitValue
 * @phpstan-import-type GroupVariants from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit\Group
 *
 * @phpstan-type WorkspaceRateLimitShape = array{
 *   group: GroupShape,
 *   limits: list<WorkspaceRateLimitValue|WorkspaceRateLimitValueShape>,
 *   models: list<string>|null,
 *   rateLimitID: string,
 *   type: 'workspace_rate_limit',
 *   workspaceID: string,
 * }
 */
final class WorkspaceRateLimit implements BaseModel
{
    /** @use SdkModel<WorkspaceRateLimitShape> */
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
     * The workspace's limiter values for this group. By default only the limiter types with a workspace-level override are listed. With `include_inherited` set to `true`, the limiter types the workspace inherits from the organization are listed too, each marked by `source`.
     *
     * @var list<WorkspaceRateLimitValue> $limits
     */
    #[Required(list: WorkspaceRateLimitValue::class)]
    public array $limits;

    /**
     * Model names this entry's limits apply to, including aliases. `null` when `group_type` is not `"model_group"`.
     *
     * @var list<string>|null $models
     */
    #[Required(list: 'string')]
    public ?array $models;

    /**
     * The `id` of the organization's RateLimit entry this entry applies to.
     */
    #[Required('rate_limit_id')]
    public string $rateLimitID;

    /**
     * ID of the Workspace this entry applies to.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new WorkspaceRateLimit()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceRateLimit::with(
     *   group: ..., limits: ..., models: ..., rateLimitID: ..., workspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceRateLimit())
     *   ->withGroup(...)
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
     * @param list<WorkspaceRateLimitValue|WorkspaceRateLimitValueShape> $limits
     * @param list<string>|null $models
     */
    public static function with(
        OrganizationRateLimitModelGroup|array|OrganizationRateLimitBatchGroup|OrganizationRateLimitTokenCountGroup|OrganizationRateLimitFilesGroup|OrganizationRateLimitSkillsGroup|OrganizationRateLimitWebSearchGroup $group,
        array $limits,
        ?array $models,
        string $rateLimitID,
        string $workspaceID,
    ): self {
        $self = new self;

        $self['group'] = $group;
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
     * The workspace's limiter values for this group. By default only the limiter types with a workspace-level override are listed. With `include_inherited` set to `true`, the limiter types the workspace inherits from the organization are listed too, each marked by `source`.
     *
     * @param list<WorkspaceRateLimitValue|WorkspaceRateLimitValueShape> $limits
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
     * The `id` of the organization's RateLimit entry this entry applies to.
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
     * ID of the Workspace this entry applies to.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
