<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsMultiagent\Agent;
use Anthropic\Beta\Sessions\BetaManagedAgentsMultiagent\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Resolved coordinator topology with a concrete agent roster.
 *
 * @phpstan-import-type AgentVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsMultiagent\Agent
 * @phpstan-import-type AgentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsMultiagent\Agent
 *
 * @phpstan-type BetaManagedAgentsMultiagentShape = array{
 *   agents: list<AgentShape>, type: Type|value-of<Type>
 * }
 */
final class BetaManagedAgentsMultiagent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentShape> */
    use SdkModel;

    /**
     * Agents the coordinator may spawn as session threads, each resolved to a specific version.
     *
     * @var list<AgentVariants> $agents
     */
    #[Required(list: Agent::class)]
    public array $agents;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsMultiagent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMultiagent::with(agents: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMultiagent)->withAgents(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
