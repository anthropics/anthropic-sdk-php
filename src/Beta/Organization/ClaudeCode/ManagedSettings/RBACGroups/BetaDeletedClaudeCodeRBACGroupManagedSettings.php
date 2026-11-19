<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaDeletedClaudeCodeRBACGroupManagedSettingsShape = array{
 *   rbacGroupID: string, type: 'claude_code_rbac_group_managed_settings_deleted'
 * }
 */
final class BetaDeletedClaudeCodeRBACGroupManagedSettings implements BaseModel
{
    /** @use SdkModel<BetaDeletedClaudeCodeRBACGroupManagedSettingsShape> */
    use SdkModel;

    /**
     * Always `claude_code_rbac_group_managed_settings_deleted`.
     *
     * @var 'claude_code_rbac_group_managed_settings_deleted' $type
     */
    #[Required(
        type: new ConstantOf('claude_code_rbac_group_managed_settings_deleted')
    )]
    public string $type = 'claude_code_rbac_group_managed_settings_deleted';

    /**
     * The RBAC Group's ID, prefixed `rbac_group_`.
     */
    #[Required('rbac_group_id')]
    public string $rbacGroupID;

    /**
     * `new BetaDeletedClaudeCodeRBACGroupManagedSettings()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaDeletedClaudeCodeRBACGroupManagedSettings::with(rbacGroupID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaDeletedClaudeCodeRBACGroupManagedSettings())->withRBACGroupID(...)
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
     */
    public static function with(string $rbacGroupID): self
    {
        $self = new self;

        $self['rbacGroupID'] = $rbacGroupID;

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
     * Always `claude_code_rbac_group_managed_settings_deleted`.
     *
     * @param 'claude_code_rbac_group_managed_settings_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
