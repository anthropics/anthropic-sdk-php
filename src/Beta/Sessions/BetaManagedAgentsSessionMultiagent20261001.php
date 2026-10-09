<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisor;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorDisabled;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorEnabled;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsDisabled;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsDisabled;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Resolved multiagent configuration with three members, as copied to the `session` at creation.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisor
 * @phpstan-import-type BetaManagedAgentsSessionMultiagentSubagentsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentSubagents
 * @phpstan-import-type BetaManagedAgentsSessionMultiagentWorkflowsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentWorkflows
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisor
 * @phpstan-import-type BetaManagedAgentsSessionMultiagentSubagentsVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentSubagents
 * @phpstan-import-type BetaManagedAgentsSessionMultiagentWorkflowsVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentWorkflows
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagent20261001Shape = array{
 *   advisor: BetaManagedAgentsMultiagentAdvisorShape,
 *   subagents: BetaManagedAgentsSessionMultiagentSubagentsShape,
 *   type: 'multiagent_20261001',
 *   workflows: BetaManagedAgentsSessionMultiagentWorkflowsShape,
 * }
 */
final class BetaManagedAgentsSessionMultiagent20261001 implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionMultiagent20261001Shape> */
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
     * @var BetaManagedAgentsSessionMultiagentSubagentsVariants $subagents
     */
    #[Required(union: BetaManagedAgentsSessionMultiagentSubagents::class)]
    public BetaManagedAgentsSessionMultiagentSubagentsEnabled|BetaManagedAgentsMultiagentSubagentsDisabled $subagents;

    /**
     * Whether the agent can start workflow runs.
     *
     * @var BetaManagedAgentsSessionMultiagentWorkflowsVariants $workflows
     */
    #[Required(union: BetaManagedAgentsSessionMultiagentWorkflows::class)]
    public BetaManagedAgentsSessionMultiagentWorkflowsEnabled|BetaManagedAgentsMultiagentWorkflowsDisabled $workflows;

    /**
     * `new BetaManagedAgentsSessionMultiagent20261001()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionMultiagent20261001::with(
     *   advisor: ..., subagents: ..., workflows: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionMultiagent20261001())
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
     * @param BetaManagedAgentsSessionMultiagentSubagentsShape $subagents
     * @param BetaManagedAgentsSessionMultiagentWorkflowsShape $workflows
     */
    public static function with(
        BetaManagedAgentsMultiagentAdvisorEnabled|array|BetaManagedAgentsMultiagentAdvisorDisabled $advisor,
        BetaManagedAgentsSessionMultiagentSubagentsEnabled|array|BetaManagedAgentsMultiagentSubagentsDisabled $subagents,
        BetaManagedAgentsSessionMultiagentWorkflowsEnabled|array|BetaManagedAgentsMultiagentWorkflowsDisabled $workflows,
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
     * @param BetaManagedAgentsSessionMultiagentSubagentsShape $subagents
     */
    public function withSubagents(
        BetaManagedAgentsSessionMultiagentSubagentsEnabled|array|BetaManagedAgentsMultiagentSubagentsDisabled $subagents,
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
     * @param BetaManagedAgentsSessionMultiagentWorkflowsShape $workflows
     */
    public function withWorkflows(
        BetaManagedAgentsSessionMultiagentWorkflowsEnabled|array|BetaManagedAgentsMultiagentWorkflowsDisabled $workflows,
    ): self {
        $self = clone $this;
        $self['workflows'] = $workflows;

        return $self;
    }
}
