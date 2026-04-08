<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRequiresAction\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The agent is idle waiting on one or more blocking user-input events (tool confirmation, custom tool result, etc.). Resolving all of them transitions the session back to running.
 *
 * @phpstan-type ManagedAgentsSessionRequiresActionShape = array{
 *   eventIDs: list<string>, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsSessionRequiresAction implements BaseModel
{
    /** @use SdkModel<ManagedAgentsSessionRequiresActionShape> */
    use SdkModel;

    /**
     * The ids of events the agent is blocked on. Resolving fewer than all re-emits `session.status_idle` with the remainder.
     *
     * @var list<string> $eventIDs
     */
    #[Required('event_ids', list: 'string')]
    public array $eventIDs;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsSessionRequiresAction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsSessionRequiresAction::with(eventIDs: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsSessionRequiresAction)->withEventIDs(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(array $eventIDs, Type|string $type): self
    {
        $self = new self;

        $self['eventIDs'] = $eventIDs;
        $self['type'] = $type;

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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
