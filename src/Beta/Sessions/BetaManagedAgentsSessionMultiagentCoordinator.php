<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentCoordinator\Agent;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Resolved coordinator topology with full agent definitions for each roster member.
 *
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentCoordinator\Agent
 * @phpstan-import-type AgentVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentCoordinator\Agent
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagentCoordinatorShape = array{
 *   agents: list<AgentShape>, type: 'coordinator'
 * }
 */
final class BetaManagedAgentsSessionMultiagentCoordinator implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionMultiagentCoordinatorShape> */
    use SdkModel;

    /** @var 'coordinator' $type */
    #[Required(type: new ConstantOf('coordinator'))]
    public string $type = 'coordinator';

    /**
     * Full `agent` definitions the coordinator may spawn as session threads.
     *
     * @var list<AgentVariants> $agents
     */
    #[Required(list: Agent::class)]
    public array $agents;

    /**
     * `new BetaManagedAgentsSessionMultiagentCoordinator()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionMultiagentCoordinator::with(agents: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionMultiagentCoordinator())->withAgents(...)
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
     * @param list<AgentShape> $agents
     */
    public static function with(array $agents): self
    {
        $self = new self;

        $self['agents'] = $agents;

        return $self;
    }

    /**
     * Full `agent` definitions the coordinator may spawn as session threads.
     *
     * @param list<AgentShape> $agents
     */
    public function withAgents(array $agents): self
    {
        $self = clone $this;
        $self['agents'] = $agents;

        return $self;
    }

    /**
     * @param 'coordinator' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
