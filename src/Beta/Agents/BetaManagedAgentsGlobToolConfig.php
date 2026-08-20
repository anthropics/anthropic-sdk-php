<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig\PermissionPolicy;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for the glob tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig\PermissionPolicy
 *
 * @phpstan-type BetaManagedAgentsGlobToolConfigShape = array{
 *   enabled: bool,
 *   name: 'glob',
 *   permissionPolicy: PermissionPolicyShape,
 *   type: 'glob',
 * }
 */
final class BetaManagedAgentsGlobToolConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsGlobToolConfigShape> */
    use SdkModel;

    /** @var 'glob' $name */
    #[Required]
    public string $name = 'glob';

    /** @var 'glob' $type */
    #[Required]
    public string $type = 'glob';

    #[Required]
    public bool $enabled;

    /**
     * Permission policy for tool execution.
     *
     * @var PermissionPolicyVariants $permissionPolicy
     */
    #[Required('permission_policy', union: PermissionPolicy::class)]
    public BetaManagedAgentsAlwaysAllowPolicy|BetaManagedAgentsAlwaysAskPolicy $permissionPolicy;

    /**
     * `new BetaManagedAgentsGlobToolConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsGlobToolConfig::with(enabled: ..., permissionPolicy: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsGlobToolConfig)
     *   ->withEnabled(...)
     *   ->withPermissionPolicy(...)
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
     * @param PermissionPolicyShape $permissionPolicy
     */
    public static function with(
        bool $enabled,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy $permissionPolicy,
    ): self {
        $self = new self;

        $self['enabled'] = $enabled;
        $self['permissionPolicy'] = $permissionPolicy;

        return $self;
    }

    public function withEnabled(bool $enabled): self
    {
        $self = clone $this;
        $self['enabled'] = $enabled;

        return $self;
    }

    /**
     * @param 'glob' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Permission policy for tool execution.
     *
     * @param PermissionPolicyShape $permissionPolicy
     */
    public function withPermissionPolicy(
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy $permissionPolicy,
    ): self {
        $self = clone $this;
        $self['permissionPolicy'] = $permissionPolicy;

        return $self;
    }

    /**
     * @param 'glob' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
