<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The agent is idle waiting on one or more blocking user-input events (tool confirmation, custom tool result, etc.). Resolving all of them transitions the session back to running.
 *
 * @phpstan-type ManagedAgentsSessionRequiresActionShape = array{
 *   eventIDs: list<string>, type: 'requires_action'
 * }
 */
final class ManagedAgentsSessionRequiresAction implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionRequiresActionShape> */
    use SdkModel;

    /** @var 'requires_action' $type */
    #[Required(type: new ConstantOf('requires_action'))]
    public string $type = 'requires_action';

    /**
     * The ids of events the agent is blocked on. Resolving fewer than all re-emits `session.status_idle` with the remainder.
     *
     * @var list<string> $eventIDs
     */
    #[Required('event_ids', list: 'string')]
    public array $eventIDs;

    /**
     * `new ManagedAgentsSessionRequiresAction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionRequiresAction::with(eventIDs: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionRequiresAction())->withEventIDs(...)
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
     * @param list<string> $eventIDs
     */
    public static function with(array $eventIDs): self
    {
        $self = new self;

        $self['eventIDs'] = $eventIDs;

        return $self;
    }

    /**
     * The ids of events the agent is blocked on. Resolving fewer than all re-emits `session.status_idle` with the remainder.
     *
     * @param list<string> $eventIDs
     */
    public function withEventIDs(array $eventIDs): self
    {
        $self = clone $this;
        $self['eventIDs'] = $eventIDs;

        return $self;
    }

    /**
     * @param 'requires_action' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
