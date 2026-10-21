<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Sessions\BetaManagedAgentsMultiagentRosterEntryParams;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A coordinator topology: the session's primary thread orchestrates work by spawning session threads, each running an agent drawn from the `agents` roster.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentRosterEntryParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsMultiagentRosterEntryParams
 * @phpstan-import-type BetaManagedAgentsMultiagentRosterEntryParamsVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsMultiagentRosterEntryParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentCoordinatorParamsShape = array{
 *   agents: list<BetaManagedAgentsMultiagentRosterEntryParamsShape>,
 *   type: 'coordinator',
 * }
 */
final class BetaManagedAgentsMultiagentCoordinatorParams implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsMultiagentCoordinatorParamsShape> */
    use SdkModel;

    /** @var 'coordinator' $type */
    #[Required(type: new ConstantOf('coordinator'))]
    public string $type = 'coordinator';

    /**
     * Agents the coordinator may spawn as session threads. 1–20 entries. Each entry is an agent ID string, a versioned `{"type":"agent","id","version"}` reference, or `{"type":"self"}` to allow recursive self-invocation. Entries must reference distinct agents (after resolving `self` and string forms); at most one `self`. Referenced agents must exist, must not be archived, and must not themselves have `multiagent` set (depth limit 1).
     *
     * @var list<BetaManagedAgentsMultiagentRosterEntryParamsVariants> $agents
     */
    #[Required(list: BetaManagedAgentsMultiagentRosterEntryParams::class)]
    public array $agents;

    /**
     * `new BetaManagedAgentsMultiagentCoordinatorParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsMultiagentCoordinatorParams::with(agents: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsMultiagentCoordinatorParams())->withAgents(...)
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
     * @param list<BetaManagedAgentsMultiagentRosterEntryParamsShape> $agents
     */
    public static function with(array $agents): self
    {
        $self = new self;

        $self['agents'] = $agents;

        return $self;
    }

    /**
     * Agents the coordinator may spawn as session threads. 1–20 entries. Each entry is an agent ID string, a versioned `{"type":"agent","id","version"}` reference, or `{"type":"self"}` to allow recursive self-invocation. Entries must reference distinct agents (after resolving `self` and string forms); at most one `self`. Referenced agents must exist, must not be archived, and must not themselves have `multiagent` set (depth limit 1).
     *
     * @param list<BetaManagedAgentsMultiagentRosterEntryParamsShape> $agents
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
