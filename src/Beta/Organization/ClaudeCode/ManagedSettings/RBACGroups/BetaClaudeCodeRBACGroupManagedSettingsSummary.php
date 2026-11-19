<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaClaudeCodeRBACGroupStatusShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupStatus
 * @phpstan-import-type BetaClaudeCodeRBACGroupStatusVariants from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups\BetaClaudeCodeRBACGroupStatus
 *
 * @phpstan-type BetaClaudeCodeRBACGroupManagedSettingsSummaryShape = array{
 *   createdAt: \DateTimeInterface,
 *   rbacGroupID: string,
 *   rbacGroupStatus: BetaClaudeCodeRBACGroupStatusShape,
 *   type: 'claude_code_rbac_group_managed_settings_summary',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class BetaClaudeCodeRBACGroupManagedSettingsSummary implements BaseModel
{
    /** @use SdkModel<BetaClaudeCodeRBACGroupManagedSettingsSummaryShape> */
    use SdkModel;

    /**
     * Always `claude_code_rbac_group_managed_settings_summary`.
     *
     * @var 'claude_code_rbac_group_managed_settings_summary' $type
     */
    #[Required(
        type: new ConstantOf('claude_code_rbac_group_managed_settings_summary')
    )]
    public string $type = 'claude_code_rbac_group_managed_settings_summary';

    /**
     * When the settings document this group uses was first stored, in RFC 3339 format. This can be earlier than when the group got its settings, and it changes if the group gets a different document.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The RBAC Group's ID, prefixed `rbac_group_`.
     */
    #[Required('rbac_group_id')]
    public string $rbacGroupID;

    /**
     * Whether the group is still one of the organization's RBAC Groups. Its `type` is `active` if it is, `deleted` if it is not, and `unknown` if that cannot be checked right now. A deleted group's settings stay in `rbac_group_order` but match no member.
     *
     * @var BetaClaudeCodeRBACGroupStatusVariants $rbacGroupStatus
     */
    #[Required('rbac_group_status', union: BetaClaudeCodeRBACGroupStatus::class)]
    public BetaClaudeCodeRBACGroupStatusActive|BetaClaudeCodeRBACGroupStatusDeleted|BetaClaudeCodeRBACGroupStatusUnknown $rbacGroupStatus;

    /**
     * When this group's settings or its position in the order last changed, in RFC 3339 format. Its position changes whenever the number of groups ahead of it changes.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new BetaClaudeCodeRBACGroupManagedSettingsSummary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeCodeRBACGroupManagedSettingsSummary::with(
     *   createdAt: ..., rbacGroupID: ..., rbacGroupStatus: ..., updatedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeCodeRBACGroupManagedSettingsSummary())
     *   ->withCreatedAt(...)
     *   ->withRBACGroupID(...)
     *   ->withRBACGroupStatus(...)
     *   ->withUpdatedAt(...)
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
     * @param BetaClaudeCodeRBACGroupStatusShape $rbacGroupStatus
     */
    public static function with(
        \DateTimeInterface $createdAt,
        string $rbacGroupID,
        BetaClaudeCodeRBACGroupStatusActive|array|BetaClaudeCodeRBACGroupStatusDeleted|BetaClaudeCodeRBACGroupStatusUnknown $rbacGroupStatus,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['createdAt'] = $createdAt;
        $self['rbacGroupID'] = $rbacGroupID;
        $self['rbacGroupStatus'] = $rbacGroupStatus;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * When the settings document this group uses was first stored, in RFC 3339 format. This can be earlier than when the group got its settings, and it changes if the group gets a different document.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The RBAC Group's ID, prefixed `rbac_group_`.
     */
    public function withRBACGroupID(string $rbacGroupID): self
    {
        $self = clone $this;
        $self['rbacGroupID'] = $rbacGroupID;

        return $self;
    }

    /**
     * Whether the group is still one of the organization's RBAC Groups. Its `type` is `active` if it is, `deleted` if it is not, and `unknown` if that cannot be checked right now. A deleted group's settings stay in `rbac_group_order` but match no member.
     *
     * @param BetaClaudeCodeRBACGroupStatusShape $rbacGroupStatus
     */
    public function withRBACGroupStatus(
        BetaClaudeCodeRBACGroupStatusActive|array|BetaClaudeCodeRBACGroupStatusDeleted|BetaClaudeCodeRBACGroupStatusUnknown $rbacGroupStatus,
    ): self {
        $self = clone $this;
        $self['rbacGroupStatus'] = $rbacGroupStatus;

        return $self;
    }

    /**
     * Always `claude_code_rbac_group_managed_settings_summary`.
     *
     * @param 'claude_code_rbac_group_managed_settings_summary' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When this group's settings or its position in the order last changed, in RFC 3339 format. Its position changes whenever the number of groups ahead of it changes.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
