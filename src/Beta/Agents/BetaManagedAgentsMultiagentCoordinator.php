<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator\Agent;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Resolved coordinator topology with a concrete agent roster.
 *
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator\Agent
 * @phpstan-import-type AgentVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator\Agent
 *
 * @phpstan-type BetaManagedAgentsMultiagentCoordinatorShape = array{
 *   agents: list<AgentShape>, type: 'coordinator'
 * }
 */
final class BetaManagedAgentsMultiagentCoordinator implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentCoordinatorShape> */
    use SdkModel;

    /** @var 'coordinator' $type */
    #[Required(type: new ConstantOf('coordinator'))]
    public string $type = 'coordinator';

    /**
     * Agents the coordinator may spawn as session threads, each resolved to a specific version.
     *
     * @var list<AgentVariants> $agents
     */
    #[Required(list: Agent::class)]
    public array $agents;

    /**
     * `new BetaManagedAgentsMultiagentCoordinator()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMultiagentCoordinator::with(agents: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMultiagentCoordinator())->withAgents(...)
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
     * Agents the coordinator may spawn as session threads, each resolved to a specific version.
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
