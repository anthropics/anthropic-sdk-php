<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401Params\Type;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Configuration for built-in agent tools. Use this to enable or disable groups of tools available to the agent.
 *
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams
 * @phpstan-import-type BetaManagedAgentsAgentToolsetDefaultConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfigParams
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401ParamsShape = array{
 *   type: Type|value-of<Type>,
 *   configs?: list<BetaManagedAgentsAgentToolConfigParams|BetaManagedAgentsAgentToolConfigParamsShape>|null,
 *   defaultConfig?: null|BetaManagedAgentsAgentToolsetDefaultConfigParams|BetaManagedAgentsAgentToolsetDefaultConfigParamsShape,
 * }
 */
final class BetaManagedAgentsAgentToolset20260401Params implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401ParamsShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * Per-tool configuration overrides.
     *
     * @var list<BetaManagedAgentsAgentToolConfigParams>|null $configs
     */
    #[Optional(list: BetaManagedAgentsAgentToolConfigParams::class)]
    public ?array $configs;

    /**
     * Default configuration for all tools in a toolset.
     */
    #[Optional('default_config', nullable: true)]
    public ?BetaManagedAgentsAgentToolsetDefaultConfigParams $defaultConfig;

    /**
     * `new BetaManagedAgentsAgentToolset20260401Params()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401Params::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401Params)->withType(...)
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
     * @param Type|value-of<Type> $type
     * @param list<BetaManagedAgentsAgentToolConfigParams|BetaManagedAgentsAgentToolConfigParamsShape>|null $configs
     * @param BetaManagedAgentsAgentToolsetDefaultConfigParams|BetaManagedAgentsAgentToolsetDefaultConfigParamsShape|null $defaultConfig
     */
    public static function with(
        Type|string $type,
        ?array $configs = null,
        BetaManagedAgentsAgentToolsetDefaultConfigParams|array|null $defaultConfig = null,
    ): self {
        $self = new self;

        $self['type'] = $type;

        null !== $configs && $self['configs'] = $configs;
        null !== $defaultConfig && $self['defaultConfig'] = $defaultConfig;

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

    /**
     * Per-tool configuration overrides.
     *
     * @param list<BetaManagedAgentsAgentToolConfigParams|BetaManagedAgentsAgentToolConfigParamsShape> $configs
     */
    public function withConfigs(array $configs): self
    {
        $self = clone $this;
        $self['configs'] = $configs;

        return $self;
    }

    /**
     * Default configuration for all tools in a toolset.
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
