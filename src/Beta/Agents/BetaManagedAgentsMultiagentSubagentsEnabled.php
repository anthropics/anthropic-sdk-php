<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent can spawn session threads.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents
 * @phpstan-import-type BetaManagedAgentsAgentReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentReference
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsVariants from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgents
 *
 * @phpstan-type BetaManagedAgentsMultiagentSubagentsEnabledShape = array{
 *   inlineAgents: BetaManagedAgentsMultiagentInlineAgentsShape,
 *   predefinedAgents: list<BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape>,
 *   type: 'enabled',
 * }
 */
final class BetaManagedAgentsMultiagentSubagentsEnabled implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentSubagentsEnabledShape> */
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
     * Predefined agents, which are saved agents that this agent can spawn as session threads, each resolved to a specific version.
     *
     * @var list<BetaManagedAgentsAgentReference> $predefinedAgents
     */
    #[Required('predefined_agents', list: BetaManagedAgentsAgentReference::class)]
    public array $predefinedAgents;

    /**
     * `new BetaManagedAgentsMultiagentSubagentsEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMultiagentSubagentsEnabled::with(
     *   inlineAgents: ..., predefinedAgents: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMultiagentSubagentsEnabled())
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
     * @param list<BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape> $predefinedAgents
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
     * Predefined agents, which are saved agents that this agent can spawn as session threads, each resolved to a specific version.
     *
     * @param list<BetaManagedAgentsAgentReference|BetaManagedAgentsAgentReferenceShape> $predefinedAgents
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
