<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfigParams\PermissionPolicy;
use Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfigParams\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration override for the bash tool.
 *
 * @phpstan-import-type PermissionPolicyVariants from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfigParams\PermissionPolicy
 * @phpstan-import-type PermissionPolicyShape from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfigParams\PermissionPolicy
 *
 * @phpstan-type BetaManagedAgentsBashToolConfigParamsShape = array{
 *   name: 'bash',
 *   enabled?: bool|null,
 *   permissionPolicy?: PermissionPolicyShape|null,
 *   type?: null|Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsBashToolConfigParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsBashToolConfigParamsShape> */
    use SdkModel;

    /**
     * Must be "bash".
     *
     * @var 'bash' $name
     */
    #[Required]
    public string $name = 'bash';

    /**
     * Whether this tool is enabled and available to Claude. Overrides the default_config setting.
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

    /** @var value-of<Type>|null $type */
    #[Optional(enum: Type::class)]
    public ?string $type;

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
     * @param Type|value-of<Type>|null $type
     */
    public static function with(
        ?bool $enabled = null,
        BetaManagedAgentsAlwaysAllowPolicy|array|BetaManagedAgentsAlwaysAskPolicy|null $permissionPolicy = null,
        Type|string|null $type = null,
    ): self {
        $self = new self;

        null !== $enabled && $self['enabled'] = $enabled;
        null !== $permissionPolicy && $self['permissionPolicy'] = $permissionPolicy;
        null !== $type && $self['type'] = $type;

        return $self;
    }

    /**
     * Must be "bash".
     *
     * @param 'bash' $name
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Whether this tool is enabled and available to Claude. Overrides the default_config setting.
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

    /**
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
