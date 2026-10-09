<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent can spawn session threads. Each thread runs a predefined agent, which is a saved agent in `predefined_agents`, or an inline agent, which the agent defines when it spawns the thread and which is not saved. If `inline_agents` is disabled, `predefined_agents` must name at least one agent.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentPredefinedAgentParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentPredefinedAgentParams
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentPredefinedAgentParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentPredefinedAgentParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentSubagentsEnabledParamsShape = array{
 *   type: 'enabled',
 *   inlineAgents?: BetaManagedAgentsMultiagentInlineAgentsParamsShape|null,
 *   predefinedAgents?: list<BetaManagedAgentsMultiagentPredefinedAgentParamsShape>|null,
 * }
 */
final class BetaManagedAgentsMultiagentSubagentsEnabledParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentSubagentsEnabledParamsShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * Whether the agent can define inline agents when it spawns session threads. Defaults to enabled.
     *
     * @var BetaManagedAgentsMultiagentInlineAgentsParamsVariants|null $inlineAgents
     */
    #[Optional(
        'inline_agents',
        union: BetaManagedAgentsMultiagentInlineAgentsParams::class,
        nullable: true,
    )]
    public BetaManagedAgentsMultiagentInlineAgentsEnabledParams|BetaManagedAgentsMultiagentInlineAgentsDisabledParams|null $inlineAgents;

    /**
     * Predefined agents that this agent can spawn as session threads. At most 20. Defaults to null. Null and an empty list both mean no predefined agents. This list is separate from `workflows.predefined_agents`, and an agent in one list is not added to the other.
     *
     * @var list<BetaManagedAgentsMultiagentPredefinedAgentParamsVariants>|null $predefinedAgents
     */
    #[Optional(
        'predefined_agents',
        list: BetaManagedAgentsMultiagentPredefinedAgentParams::class,
        nullable: true,
    )]
    public ?array $predefinedAgents;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaManagedAgentsMultiagentInlineAgentsParamsShape|null $inlineAgents
     * @param list<BetaManagedAgentsMultiagentPredefinedAgentParamsShape>|null $predefinedAgents
     */
    public static function with(
        BetaManagedAgentsMultiagentInlineAgentsEnabledParams|array|BetaManagedAgentsMultiagentInlineAgentsDisabledParams|null $inlineAgents = null,
        ?array $predefinedAgents = null,
    ): self {
        $self = new self;

        null !== $inlineAgents && $self['inlineAgents'] = $inlineAgents;
        null !== $predefinedAgents && $self['predefinedAgents'] = $predefinedAgents;

        return $self;
    }

    /**
     * @param 'enabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Whether the agent can define inline agents when it spawns session threads. Defaults to enabled.
     *
     * @param BetaManagedAgentsMultiagentInlineAgentsParamsShape|null $inlineAgents
     */
    public function withInlineAgents(
        BetaManagedAgentsMultiagentInlineAgentsEnabledParams|array|BetaManagedAgentsMultiagentInlineAgentsDisabledParams|null $inlineAgents,
    ): self {
        $self = clone $this;
        $self['inlineAgents'] = $inlineAgents;

        return $self;
    }

    /**
     * Predefined agents that this agent can spawn as session threads. At most 20. Defaults to null. Null and an empty list both mean no predefined agents. This list is separate from `workflows.predefined_agents`, and an agent in one list is not added to the other.
     *
     * @param list<BetaManagedAgentsMultiagentPredefinedAgentParamsShape>|null $predefinedAgents
     */
    public function withPredefinedAgents(?array $predefinedAgents): self
    {
        $self = clone $this;
        $self['predefinedAgents'] = $predefinedAgents;

        return $self;
    }
}
