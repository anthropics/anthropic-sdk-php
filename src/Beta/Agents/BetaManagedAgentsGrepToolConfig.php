<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfig\PermissionPolicy;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for the grep tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfig\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfig\PermissionPolicy
 *
 * @phpstan-type BetaManagedAgentsGrepToolConfigShape = array{
 *   enabled: bool,
 *   name: 'grep',
 *   permissionPolicy: PermissionPolicyShape,
 *   type: 'grep',
 * }
 */
final class BetaManagedAgentsGrepToolConfig implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsGrepToolConfigShape> */
    use SdkModel;

    /** @var 'grep' $name */
    #[Required]
    public string $name = 'grep';

    /** @var 'grep' $type */
    #[Required]
    public string $type = 'grep';

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
     * `new BetaManagedAgentsGrepToolConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsGrepToolConfig::with(enabled: ..., permissionPolicy: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsGrepToolConfig)
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
     * @param 'grep' $name
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
     * @param 'grep' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
