<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfigParams\PermissionPolicy;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Default configuration for all tools from an MCP server.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfigParams\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfigParams\PermissionPolicy
 *
 * @phpstan-type BetaManagedAgentsMCPToolsetDefaultConfigParamsShape = array{
 *   enabled?: bool|null, permissionPolicy?: PermissionPolicyShape|null
 * }
 */
final class BetaManagedAgentsMCPToolsetDefaultConfigParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMCPToolsetDefaultConfigParamsShape> */
    use SdkModel;

    /**
     * Whether tools are enabled by default. Defaults to true if not specified.
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
        ?bool $enabled = null,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy = null,
    ): self {
        $self = new self;

        null !== $enabled && $self['enabled'] = $enabled;
        null !== $permissionPolicy && $self['permissionPolicy'] = $permissionPolicy;

        return $self;
    }

    /**
     * Whether tools are enabled by default. Defaults to true if not specified.
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
