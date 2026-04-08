<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfig
 * @phpstan-import-type BetaManagedAgentsAgentToolsetDefaultConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfig
 *
 * @phpstan-type BetaManagedAgentsAgentToolset20260401Shape = array{
 *   configs: list<BetaManagedAgentsAgentToolConfig|BetaManagedAgentsAgentToolConfigShape>,
 *   defaultConfig: BetaManagedAgentsAgentToolsetDefaultConfig|BetaManagedAgentsAgentToolsetDefaultConfigShape,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsAgentToolset20260401 implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsAgentToolset20260401Shape> */
    use SdkModel;

    /** @var list<BetaManagedAgentsAgentToolConfig> $configs */
    #[Required(list: BetaManagedAgentsAgentToolConfig::class)]
    public array $configs;

    /**
     * Resolved default configuration for agent tools.
     */
    #[Required('default_config')]
    public BetaManagedAgentsAgentToolsetDefaultConfig $defaultConfig;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsAgentToolset20260401()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsAgentToolset20260401::with(
     *   configs: ..., defaultConfig: ..., type: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsAgentToolset20260401)
     *   ->withConfigs(...)
     *   ->withDefaultConfig(...)
     *   ->withType(...)
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
     * @param list<BetaManagedAgentsAgentToolConfig|BetaManagedAgentsAgentToolConfigShape> $configs
     * @param BetaManagedAgentsAgentToolsetDefaultConfig|BetaManagedAgentsAgentToolsetDefaultConfigShape $defaultConfig
     * @param Type|value-of<Type> $type
     */
    public static function with(
        array $configs,
        BetaManagedAgentsAgentToolsetDefaultConfig|array $defaultConfig,
        Type|string $type,
    ): self {
        $self = new self;

        $self['configs'] = $configs;
        $self['defaultConfig'] = $defaultConfig;
        $self['type'] = $type;

        return $self;
    }

    /**
     * @param list<BetaManagedAgentsAgentToolConfig|BetaManagedAgentsAgentToolConfigShape> $configs
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
