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
 * The agent can start workflow runs.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents
 * @phpstan-import-type BetaManagedAgentsSessionThreadAgentShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagentWorkflowsEnabledShape = array{
 *   inlineAgents: BetaManagedAgentsMultiagentInlineAgentsShape,
 *   predefinedAgents: list<BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsSessionThreadAgentShape>,
 *   type: 'enabled',
 * }
 */
final class BetaManagedAgentsSessionMultiagentWorkflowsEnabled implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionMultiagentWorkflowsEnabledShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * Whether a run's plan can define inline agents, which are not saved.
     *
     * @var BetaManagedAgentsMultiagentInlineAgentsVariants $inlineAgents
     */
    #[Required(
        'inline_agents',
        union: BetaManagedAgentsMultiagentInlineAgents::class
    )]
    public BetaManagedAgentsMultiagentInlineAgentsEnabled|BetaManagedAgentsMultiagentInlineAgentsDisabled $inlineAgents;

    /**
     * Full `agent` definitions of the predefined agents, which are saved agents that a run's plan can use.
     *
     * @var list<BetaManagedAgentsSessionThreadAgent> $predefinedAgents
     */
    #[Required(
        'predefined_agents',
        list: BetaManagedAgentsSessionThreadAgent::class
    )]
    public array $predefinedAgents;

    /**
     * `new BetaManagedAgentsSessionMultiagentWorkflowsEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionMultiagentWorkflowsEnabled::with(
     *   inlineAgents: ..., predefinedAgents: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionMultiagentWorkflowsEnabled())
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
     * Whether a run's plan can define inline agents, which are not saved.
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
     * Full `agent` definitions of the predefined agents, which are saved agents that a run's plan can use.
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
