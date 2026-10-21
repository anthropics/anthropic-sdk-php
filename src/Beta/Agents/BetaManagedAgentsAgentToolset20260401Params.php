<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Configuration for built-in agent tools. Use this to enable or disable groups of tools available to the agent.
 *
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams
 * @phpstan-import-type BetaManagedAgentsAgentToolsetDefaultConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfigParams
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401ParamsShape = array{
 *   type: 'agent_toolset_20260401',
 *   configs?: list<BetaManagedAgentsAgentToolConfigParamsShape>|null,
 *   defaultConfig?: null|BetaManagedAgentsAgentToolsetDefaultConfigParams|BetaManagedAgentsAgentToolsetDefaultConfigParamsShape,
 * }
 */
final class BetaManagedAgentsAgentToolset20260401Params implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401ParamsShape> */
    use SdkModel;

    /** @var 'agent_toolset_20260401' $type */
    #[Required(type: new ConstantOf('agent_toolset_20260401'))]
    public string $type = 'agent_toolset_20260401';

    /**
     * Per-tool configuration overrides.
     *
     * @var list<BetaManagedAgentsAgentToolConfigParamsVariants>|null $configs
     */
    #[Optional(list: BetaManagedAgentsAgentToolConfigParams::class)]
    public ?array $configs;

    /**
     * Default configuration applied to all tools in this set.
     */
    #[Optional('default_config', nullable: true)]
    public ?BetaManagedAgentsAgentToolsetDefaultConfigParams $defaultConfig;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaManagedAgentsAgentToolConfigParamsShape>|null $configs
     * @param BetaManagedAgentsAgentToolsetDefaultConfigParams|BetaManagedAgentsAgentToolsetDefaultConfigParamsShape|null $defaultConfig
     */
    public static function with(
        ?array $configs = null,
        BetaManagedAgentsAgentToolsetDefaultConfigParams|array|null $defaultConfig = null,
    ): self {
        $self = new self;

        null !== $configs && $self['configs'] = $configs;
        null !== $defaultConfig && $self['defaultConfig'] = $defaultConfig;

        return $self;
    }

    /**
     * @param 'agent_toolset_20260401' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Per-tool configuration overrides.
     *
     * @param list<BetaManagedAgentsAgentToolConfigParamsShape> $configs
     */
    public function withConfigs(array $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }

    /**
     * Default configuration applied to all tools in this set.
     *
     * @param BetaManagedAgentsAgentToolsetDefaultConfigParams|BetaManagedAgentsAgentToolsetDefaultConfigParamsShape|null $defaultConfig
     */
    public function withDefaultConfig(
        BetaManagedAgentsAgentToolsetDefaultConfigParams|array|null $defaultConfig
    ): self {
        $self = clone $this;
        $self['defaultConfig'] = $defaultConfig;

        return $self;
    }
}
