<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentCoordinator\Type;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThreadAgent;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Resolved coordinator topology with full agent definitions for each roster member.
 *
 * @phpstan-import-type ManagedAgentsSessionThreadAgentShape from \Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThreadAgent
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagentCoordinatorShape = array{
 *   agents: list<ManagedAgentsSessionThreadAgent|ManagedAgentsSessionThreadAgentShape>,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsSessionMultiagentCoordinator implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsSessionMultiagentCoordinatorShape> */
    use SdkModel;

    /**
     * Full `agent` definitions the coordinator may spawn as session threads.
     *
     * @var list<ManagedAgentsSessionThreadAgent> $agents
     */
    #[Required(list: ManagedAgentsSessionThreadAgent::class)]
    public array $agents;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsSessionMultiagentCoordinator()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsSessionMultiagentCoordinator::with(agents: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsSessionMultiagentCoordinator)
     *   ->withAgents(...)
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
     * @param list<ManagedAgentsSessionThreadAgent|ManagedAgentsSessionThreadAgentShape> $agents
     * @param Type|value-of<Type> $type
     */
    public static function with(array $agents, Type|string $type): self
    {
        $self = new self;

        $self['agents'] = $agents;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Full `agent` definitions the coordinator may spawn as session threads.
     *
     * @param list<ManagedAgentsSessionThreadAgent|ManagedAgentsSessionThreadAgentShape> $agents
     */
    public function withAgents(array $agents): self
    {
        $self = clone $this;
        $self['agents'] = $agents;

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
