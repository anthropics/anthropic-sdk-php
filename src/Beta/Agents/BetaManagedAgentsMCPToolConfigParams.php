<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfigParams\PermissionPolicy;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration override for a specific MCP tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfigParams\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfigParams\PermissionPolicy
 *
 * @phpstan-type BetaManagedAgentsMCPToolConfigParamsShape = array{
 *   name: string,
 *   enabled?: bool|null,
 *   permissionPolicy?: PermissionPolicyShape|null,
 * }
 */
final class BetaManagedAgentsMCPToolConfigParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPToolConfigParamsShape> */
    use SdkModel;

    /**
     * Name of the MCP tool to configure. 1-128 characters.
     */
    #[Required]
    public string $name;

    /**
     * Whether this tool is enabled. Overrides the `default_config` setting.
     */
    #[Optional(nullable: true)]
    public ?bool $enabled;

    /**
     * Permission policy for tool execution.
     *
     * @var PermissionPolicyVariants|null $permissionPolicy
     */
    #[Optional(
        'permission_policy',
        union: PermissionPolicy::class,
        nullable: true
    )]
    public BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy;

    /**
     * `new BetaManagedAgentsMCPToolConfigParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMCPToolConfigParams::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMCPToolConfigParams)->withName(...)
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
     * @param PermissionPolicyShape|null $permissionPolicy
     */
    public static function with(
        string $name,
        ?bool $enabled = null,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy = null,
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $enabled && $self['enabled'] = $enabled;
        null !== $permissionPolicy && $self['permissionPolicy'] = $permissionPolicy;

        return $self;
    }

    /**
     * Name of the MCP tool to configure. 1-128 characters.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Whether this tool is enabled. Overrides the `default_config` setting.
     */
    public function withEnabled(?bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * Permission policy for tool execution.
     *
     * @param PermissionPolicyShape|null $permissionPolicy
     */
    public function withPermissionPolicy(
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy,
    ): self {
        $self = clone $this;
        $self['permissionPolicy'] = $permissionPolicy;

        return $self;
    }
}
