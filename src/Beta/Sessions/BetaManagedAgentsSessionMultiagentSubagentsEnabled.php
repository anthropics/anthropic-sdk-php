<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsDisabled;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsEnabled;
use Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent can spawn session threads.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents
 * @phpstan-import-type BetaManagedAgentsSessionThreadAgentShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagentSubagentsEnabledShape = array{
 *   inlineAgents: BetaManagedAgentsMultiagentInlineAgentsShape,
 *   predefinedAgents: list<BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsSessionThreadAgentShape>,
 *   type: 'enabled',
 * }
 */
final class BetaManagedAgentsSessionMultiagentSubagentsEnabled implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionMultiagentSubagentsEnabledShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * Whether the agent can define inline agents, which are not saved, when it spawns session threads.
     *
     * @var BetaManagedAgentsMultiagentInlineAgentsVariants $inlineAgents
     */
    #[Required(
        'inline_agents',
        union: BetaManagedAgentsMultiagentInlineAgents::class
    )]
    public BetaManagedAgentsMultiagentInlineAgentsEnabled|BetaManagedAgentsMultiagentInlineAgentsDisabled $inlineAgents;

    /**
     * Full `agent` definitions of the predefined agents, which are saved agents that this agent can spawn as session threads.
     *
     * @var list<BetaManagedAgentsSessionThreadAgent> $predefinedAgents
     */
    #[Required(
        'predefined_agents',
        list: BetaManagedAgentsSessionThreadAgent::class
    )]
    public array $predefinedAgents;

    /**
     * `new BetaManagedAgentsSessionMultiagentSubagentsEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionMultiagentSubagentsEnabled::with(
     *   inlineAgents: ..., predefinedAgents: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionMultiagentSubagentsEnabled())
     *   ->withInlineAgents(...)
     *   ->withPredefinedAgents(...)
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
     * @param BetaManagedAgentsMultiagentInlineAgentsShape $inlineAgents
     * @param list<BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsSessionThreadAgentShape> $predefinedAgents
     */
    public static function with(
        BetaManagedAgentsMultiagentInlineAgentsEnabled|array|BetaManagedAgentsMultiagentInlineAgentsDisabled $inlineAgents,
        array $predefinedAgents,
    ): self {
        $self = new self;

        $self['inlineAgents'] = $inlineAgents;
        $self['predefinedAgents'] = $predefinedAgents;

        return $self;
    }

    /**
     * Whether the agent can define inline agents, which are not saved, when it spawns session threads.
     *
     * @param BetaManagedAgentsMultiagentInlineAgentsShape $inlineAgents
     */
    public function withInlineAgents(
        BetaManagedAgentsMultiagentInlineAgentsEnabled|array|BetaManagedAgentsMultiagentInlineAgentsDisabled $inlineAgents,
    ): self {
        $self = clone $this;
        $self['inlineAgents'] = $inlineAgents;

        return $self;
    }

    /**
     * Full `agent` definitions of the predefined agents, which are saved agents that this agent can spawn as session threads.
     *
     * @param list<BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsSessionThreadAgentShape> $predefinedAgents
     */
    public function withPredefinedAgents(array $predefinedAgents): self
    {
        $self = clone $this;
        $self['predefinedAgents'] = $predefinedAgents;

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
}
