<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfig
 * @phpstan-import-type BetaManagedAgentsAgentToolsetDefaultConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfig
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigVariants from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfig
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401Shape = array{
 *   configs: list<BetaManagedAgentsAgentToolConfigShape>,
 *   defaultConfig: BetaManagedAgentsAgentToolsetDefaultConfig|BetaManagedAgentsAgentToolsetDefaultConfigShape,
 *   type: 'agent_toolset_20260401',
 * }
 */
final class BetaManagedAgentsAgentToolset20260401 implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401Shape> */
    use SdkModel;

    /** @var 'agent_toolset_20260401' $type */
    #[Required(type: new ConstantOf('agent_toolset_20260401'))]
    public string $type = 'agent_toolset_20260401';

    /** @var list<BetaManagedAgentsAgentToolConfigVariants> $configs */
    #[Required(list: BetaManagedAgentsAgentToolConfig::class)]
    public array $configs;

    /**
     * Resolved default configuration for agent tools.
     */
    #[Required('default_config')]
    public BetaManagedAgentsAgentToolsetDefaultConfig $defaultConfig;

    /**
     * `new BetaManagedAgentsAgentToolset20260401()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401::with(configs: ..., defaultConfig: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401())
     *   ->withConfigs(...)
     *   ->withDefaultConfig(...)
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
     * @param list<BetaManagedAgentsAgentToolConfigShape> $configs
     * @param BetaManagedAgentsAgentToolsetDefaultConfig|BetaManagedAgentsAgentToolsetDefaultConfigShape $defaultConfig
     */
    public static function with(
        array $configs,
        BetaManagedAgentsAgentToolsetDefaultConfig|array $defaultConfig,
    ): self {
        $self = new self;

        $self['configs'] = $configs;
        $self['defaultConfig'] = $defaultConfig;

        return $self;
    }

    /**
     * @param list<BetaManagedAgentsAgentToolConfigShape> $configs
     */
    public function withConfigs(array $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }

    /**
     * Resolved default configuration for agent tools.
     *
     * @param BetaManagedAgentsAgentToolsetDefaultConfig|BetaManagedAgentsAgentToolsetDefaultConfigShape $defaultConfig
     */
    public function withDefaultConfig(
        BetaManagedAgentsAgentToolsetDefaultConfig|array $defaultConfig
    ): self {
        $self = clone $this;
        $self['defaultConfig'] = $defaultConfig;

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
}
