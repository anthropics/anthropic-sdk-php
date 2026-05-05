<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Resolved coordinator topology with a concrete agent roster.
 *
 * @phpstan-import-type BetaManagedAgentsAgentReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentReference
 *
 * @phpstan-type BetaManagedAgentsMultiagentCoordinatorShape = array{
 *   agents: list<BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape>,
 *   type: Type|value-of<Type>,
 * }
 */
final class BetaManagedAgentsMultiagentCoordinator implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentCoordinatorShape> */
    use SdkModel;

    /**
     * Agents the coordinator may spawn as session threads, each resolved to a specific version.
     *
     * @var list<BetaManagedAgentsAgentReference> $agents
     */
    #[Required(list: BetaManagedAgentsAgentReference::class)]
    public array $agents;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaManagedAgentsMultiagentCoordinator()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMultiagentCoordinator::with(agents: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMultiagentCoordinator)->withAgents(...)->withType(...)
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
     * @param list<BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape> $agents
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
     * @param list<BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape> $agents
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
