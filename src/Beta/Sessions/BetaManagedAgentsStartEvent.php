<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Opens a preview of a buffered event. Carries the previewed event's type and id only. Followed by zero or more event_delta events with the same event id, normally concluded by the buffered event carrying that id. If the producing model request ends without that event (an error or interrupt mid-stream), its terminal span.model_request_end closes the preview. Only sent on stream connections that opt in via event_deltas; never appears in event history.
 *
 * @phpstan-import-type BetaManagedAgentsStartEventPreviewShape from \Anthropic\Beta\Sessions\BetaManagedAgentsStartEventPreview
 * @phpstan-import-type BetaManagedAgentsStartEventPreviewVariants from \Anthropic\Beta\Sessions\BetaManagedAgentsStartEventPreview
 *
 * @phpstan-type BetaManagedAgentsStartEventShape = array{
 *   event: BetaManagedAgentsStartEventPreviewShape, type: 'event_start'
 * }
 */
final class BetaManagedAgentsStartEvent implements BaseModel
{
    /** @use SdkModel<BetaManagedAgentsStartEventShape> */
    use SdkModel;

    /** @var 'event_start' $type */
    #[Required(type: new ConstantOf('event_start'))]
    public string $type = 'event_start';

    /**
     * The previewed event's type and id. The event type determines which delta types the preview's event_delta events carry: agent.message events stream content_delta fragments; agent.thinking previews are start-only — no deltas follow, and the buffered agent.thinking with the same id concludes them.
     *
     * @var BetaManagedAgentsStartEventPreviewVariants $event
     */
    #[Required(union: BetaManagedAgentsStartEventPreview::class)]
    public BetaManagedAgentsAgentMessagePreview|BetaManagedAgentsAgentThinkingPreview $event;

    /**
     * `new BetaManagedAgentsStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaManagedAgentsStartEvent::with(event: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaManagedAgentsStartEvent())->withEvent(...)
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
     * @param BetaManagedAgentsStartEventPreviewShape $event
     */
    public static function with(
        BetaManagedAgentsAgentMessagePreview|array|BetaManagedAgentsAgentThinkingPreview $event,
    ): self {
        $self = new self;

        $self['event'] = $event;

        return $self;
    }

    /**
     * The previewed event's type and id. The event type determines which delta types the preview's event_delta events carry: agent.message events stream content_delta fragments; agent.thinking previews are start-only — no deltas follow, and the buffered agent.thinking with the same id concludes them.
     *
     * @param BetaManagedAgentsStartEventPreviewShape $event
     */
    public function withEvent(
        BetaManagedAgentsAgentMessagePreview|array|BetaManagedAgentsAgentThinkingPreview $event,
    ): self {
        $self = clone $this;
        $self['event'] = $event;

        return $self;
    }

    /**
     * @param 'event_start' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
