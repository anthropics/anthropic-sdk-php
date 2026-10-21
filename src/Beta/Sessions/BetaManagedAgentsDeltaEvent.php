<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An incremental update to an event that is still being streamed. Deltas are best-effort and may stop early; when the buffered event with id == event_id is produced it carries the complete content. A model request that ends early (an error or interrupt) produces no buffered event — its terminal span.model_request_end closes the preview. Only sent on stream connections that opt in via event_deltas; never appears in event history.
 *
 * @phpstan-import-type BetaManagedAgentsDeltaContentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsDeltaContent
 *
 * @phpstan-type BetaManagedAgentsDeltaEventShape = array{
 *   delta: BetaManagedAgentsDeltaContent|BetaManagedAgentsDeltaContentShape,
 *   eventID: string,
 *   type: 'event_delta',
 * }
 */
final class BetaManagedAgentsDeltaEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsDeltaEventShape> */
    use SdkModel;

    /** @var 'event_delta' $type */
    #[Required(type: new ConstantOf('event_delta'))]
    public string $type = 'event_delta';

    /**
     * One fragment of the previewed event. The delta type is named for the previewed event's field it streams into: agent.message events stream content_delta fragments, each a partial element of the content array.
     */
    #[Required]
    public BetaManagedAgentsDeltaContent $delta;

    /**
     * The id of the event being previewed. Matches event.id on the corresponding event_start and the buffered event that reconciles the preview.
     */
    #[Required('event_id')]
    public string $eventID;

    /**
     * `new BetaManagedAgentsDeltaEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsDeltaEvent::with(delta: ..., eventID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsDeltaEvent())->withDelta(...)->withEventID(...)
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
     * @param BetaManagedAgentsDeltaContent|BetaManagedAgentsDeltaContentShape $delta
     */
    public static function with(
        BetaManagedAgentsDeltaContent|array $delta,
        string $eventID
    ): self {
        $self = new self;

        $self['delta'] = $delta;
        $self['eventID'] = $eventID;

        return $self;
    }

    /**
     * One fragment of the previewed event. The delta type is named for the previewed event's field it streams into: agent.message events stream content_delta fragments, each a partial element of the content array.
     *
     * @param BetaManagedAgentsDeltaContent|BetaManagedAgentsDeltaContentShape $delta
     */
    public function withDelta(BetaManagedAgentsDeltaContent|array $delta): self
    {
        $self = clone $this;
        $self['delta'] = $delta;

        return $self;
    }

    /**
     * The id of the event being previewed. Matches event.id on the corresponding event_start and the buffered event that reconciles the preview.
     */
    public function withEventID(string $eventID): self
    {
        $self = clone $this;
        $self['eventID'] = $eventID;

        return $self;
    }

    /**
     * @param 'event_delta' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
