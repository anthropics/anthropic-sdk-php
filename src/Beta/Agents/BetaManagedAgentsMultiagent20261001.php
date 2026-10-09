<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Resolved multiagent configuration with three members, each enabled or disabled on its own.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisor
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagents
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflows
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisor
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagents
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflows
 *
 * @phpstan-type BetaManagedAgentsMultiagent20261001Shape = array{
 *   advisor: BetaManagedAgentsMultiagentAdvisorShape,
 *   subagents: BetaManagedAgentsMultiagentSubagentsShape,
 *   type: 'multiagent_20261001',
 *   workflows: BetaManagedAgentsMultiagentWorkflowsShape,
 * }
 */
final class BetaManagedAgentsMultiagent20261001 implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagent20261001Shape> */
    use SdkModel;

    /** @var 'multiagent_20261001' $type */
    #[Required(type: new ConstantOf('multiagent_20261001'))]
    public string $type = 'multiagent_20261001';

    /**
     * Whether the session's primary thread can consult an advisor model.
     *
     * @var BetaManagedAgentsMultiagentAdvisorVariants $advisor
     */
    #[Required(union: BetaManagedAgentsMultiagentAdvisor::class)]
    public BetaManagedAgentsMultiagentAdvisorEnabled|BetaManagedAgentsMultiagentAdvisorDisabled $advisor;

    /**
     * Whether the agent can spawn session threads.
     *
     * @var BetaManagedAgentsMultiagentSubagentsVariants $subagents
     */
    #[Required(union: BetaManagedAgentsMultiagentSubagents::class)]
    public BetaManagedAgentsMultiagentSubagentsEnabled|BetaManagedAgentsMultiagentSubagentsDisabled $subagents;

    /**
     * Whether the agent can start workflow runs.
     *
     * @var BetaManagedAgentsMultiagentWorkflowsVariants $workflows
     */
    #[Required(union: BetaManagedAgentsMultiagentWorkflows::class)]
    public BetaManagedAgentsMultiagentWorkflowsEnabled|BetaManagedAgentsMultiagentWorkflowsDisabled $workflows;

    /**
     * `new BetaManagedAgentsMultiagent20261001()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMultiagent20261001::with(
     *   advisor: ..., subagents: ..., workflows: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMultiagent20261001())
     *   ->withAdvisor(...)
     *   ->withSubagents(...)
     *   ->withWorkflows(...)
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
     * @param BetaManagedAgentsMultiagentAdvisorShape $advisor
     * @param BetaManagedAgentsMultiagentSubagentsShape $subagents
     * @param BetaManagedAgentsMultiagentWorkflowsShape $workflows
     */
    public static function with(
        BetaManagedAgentsMultiagentAdvisorEnabled|array|BetaManagedAgentsMultiagentAdvisorDisabled $advisor,
        BetaManagedAgentsMultiagentSubagentsEnabled|array|BetaManagedAgentsMultiagentSubagentsDisabled $subagents,
        BetaManagedAgentsMultiagentWorkflowsEnabled|array|BetaManagedAgentsMultiagentWorkflowsDisabled $workflows,
    ): self {
        $self = new self;

        $self['advisor'] = $advisor;
        $self['subagents'] = $subagents;
        $self['workflows'] = $workflows;

        return $self;
    }

    /**
     * Whether the session's primary thread can consult an advisor model.
     *
     * @param BetaManagedAgentsMultiagentAdvisorShape $advisor
     */
    public function withAdvisor(
        BetaManagedAgentsMultiagentAdvisorEnabled|array|BetaManagedAgentsMultiagentAdvisorDisabled $advisor,
    ): self {
        $self = clone $this;
        $self['advisor'] = $advisor;

        return $self;
    }

    /**
     * Whether the agent can spawn session threads.
     *
     * @param BetaManagedAgentsMultiagentSubagentsShape $subagents
     */
    public function withSubagents(
        BetaManagedAgentsMultiagentSubagentsEnabled|array|BetaManagedAgentsMultiagentSubagentsDisabled $subagents,
    ): self {
        $self = clone $this;
        $self['subagents'] = $subagents;

        return $self;
    }

    /**
     * @param 'multiagent_20261001' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Whether the agent can start workflow runs.
     *
     * @param BetaManagedAgentsMultiagentWorkflowsShape $workflows
     */
    public function withWorkflows(
        BetaManagedAgentsMultiagentWorkflowsEnabled|array|BetaManagedAgentsMultiagentWorkflowsDisabled $workflows,
    ): self {
        $self = clone $this;
        $self['workflows'] = $workflows;

        return $self;
    }
}
