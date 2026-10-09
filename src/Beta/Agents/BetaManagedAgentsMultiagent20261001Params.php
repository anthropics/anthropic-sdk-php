<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Multiagent configuration with three members, each enabled or disabled on its own. On an update, if the agent's stored `multiagent` also has type `multiagent_20261001`, this configuration is merged into the stored one, level by level, instead of replacing it. A key that the update omits keeps its stored value. A key sent as null takes its default, on create as well, so `"workflows": null` enables workflows. An object sent with a `type` other than the stored one replaces the stored object, and the keys that it omits take their defaults. A `predefined_agents` list that is sent replaces the stored list. Every object that is sent needs its `type`, and an enabled `advisor` needs its `model`. Other validation applies to the merged result.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorParams
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorParams
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsParamsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsParams
 *
 * @phpstan-type BetaManagedAgentsMultiagent20261001ParamsShape = array{
 *   type: 'multiagent_20261001',
 *   advisor?: BetaManagedAgentsMultiagentAdvisorParamsShape|null,
 *   subagents?: BetaManagedAgentsMultiagentSubagentsParamsShape|null,
 *   workflows?: BetaManagedAgentsMultiagentWorkflowsParamsShape|null,
 * }
 */
final class BetaManagedAgentsMultiagent20261001Params implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagent20261001ParamsShape> */
    use SdkModel;

    /** @var 'multiagent_20261001' $type */
    #[Required(type: new ConstantOf('multiagent_20261001'))]
    public string $type = 'multiagent_20261001';

    /**
     * Whether the session's primary thread can consult an advisor model. Defaults to disabled.
     *
     * @var BetaManagedAgentsMultiagentAdvisorParamsVariants|null $advisor
     */
    #[Optional(
        union: BetaManagedAgentsMultiagentAdvisorParams::class,
        nullable: true
    )]
    public BetaManagedAgentsMultiagentAdvisorEnabledParams|BetaManagedAgentsMultiagentAdvisorDisabledParams|null $advisor;

    /**
     * Whether the agent can spawn session threads. Defaults to enabled.
     *
     * @var BetaManagedAgentsMultiagentSubagentsParamsVariants|null $subagents
     */
    #[Optional(
        union: BetaManagedAgentsMultiagentSubagentsParams::class,
        nullable: true
    )]
    public BetaManagedAgentsMultiagentSubagentsEnabledParams|BetaManagedAgentsMultiagentSubagentsDisabledParams|null $subagents;

    /**
     * Whether the agent can start workflow runs. Defaults to enabled.
     *
     * @var BetaManagedAgentsMultiagentWorkflowsParamsVariants|null $workflows
     */
    #[Optional(
        union: BetaManagedAgentsMultiagentWorkflowsParams::class,
        nullable: true
    )]
    public BetaManagedAgentsMultiagentWorkflowsEnabledParams|BetaManagedAgentsMultiagentWorkflowsDisabledParams|null $workflows;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaManagedAgentsMultiagentAdvisorParamsShape|null $advisor
     * @param BetaManagedAgentsMultiagentSubagentsParamsShape|null $subagents
     * @param BetaManagedAgentsMultiagentWorkflowsParamsShape|null $workflows
     */
    public static function with(
        BetaManagedAgentsMultiagentAdvisorEnabledParams|array|BetaManagedAgentsMultiagentAdvisorDisabledParams|null $advisor = null,
        BetaManagedAgentsMultiagentSubagentsEnabledParams|array|BetaManagedAgentsMultiagentSubagentsDisabledParams|null $subagents = null,
        BetaManagedAgentsMultiagentWorkflowsEnabledParams|array|BetaManagedAgentsMultiagentWorkflowsDisabledParams|null $workflows = null,
    ): self {
        $self = new self;

        null !== $advisor && $self['advisor'] = $advisor;
        null !== $subagents && $self['subagents'] = $subagents;
        null !== $workflows && $self['workflows'] = $workflows;

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
     * Whether the session's primary thread can consult an advisor model. Defaults to disabled.
     *
     * @param BetaManagedAgentsMultiagentAdvisorParamsShape|null $advisor
     */
    public function withAdvisor(
        BetaManagedAgentsMultiagentAdvisorEnabledParams|array|BetaManagedAgentsMultiagentAdvisorDisabledParams|null $advisor,
    ): self {
        $self = clone $this;
        $self['advisor'] = $advisor;

        return $self;
    }

    /**
     * Whether the agent can spawn session threads. Defaults to enabled.
     *
     * @param BetaManagedAgentsMultiagentSubagentsParamsShape|null $subagents
     */
    public function withSubagents(
        BetaManagedAgentsMultiagentSubagentsEnabledParams|array|BetaManagedAgentsMultiagentSubagentsDisabledParams|null $subagents,
    ): self {
        $self = clone $this;
        $self['subagents'] = $subagents;

        return $self;
    }

    /**
     * Whether the agent can start workflow runs. Defaults to enabled.
     *
     * @param BetaManagedAgentsMultiagentWorkflowsParamsShape|null $workflows
     */
    public function withWorkflows(
        BetaManagedAgentsMultiagentWorkflowsEnabledParams|array|BetaManagedAgentsMultiagentWorkflowsDisabledParams|null $workflows,
    ): self {
        $self = clone $this;
        $self['workflows'] = $workflows;

        return $self;
    }
}
