<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Stream Events.
 *
 * @see Anthropic\Services\Beta\Sessions\EventsService::streamStream()
 *
 * @phpstan-type EventStreamParamsShape = array{
 *   eventDeltas?: list<BetaManagedAgentsDeltaType|value-of<BetaManagedAgentsDeltaType>>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class EventStreamParams implements BaseModel
{
    /** @use SdkModel<EventStreamParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * When set, this connection also receives streaming deltas (`event_start`, `event_delta`) while an event is being produced, before the event itself arrives. Deltas are best-effort; when the final event is produced it carries the complete content. A model request that ends early (an error or interrupt) produces no final event — its terminal `span.model_request_end` closes the preview. Accepts one or more event types to preview and may be repeated: `agent.message` streams `content_delta` fragments; `agent.thinking` is start-only — a signal that the agent has begun extended thinking, concluded by the `agent.thinking` event itself. Only previews of the requested event types are sent.
     *
     * @var list<value-of<BetaManagedAgentsDeltaType>>|null $eventDeltas
     */
    #[Optional(list: BetaManagedAgentsDeltaType::class)]
    public ?array $eventDeltas;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaManagedAgentsDeltaType|value-of<BetaManagedAgentsDeltaType>>|null $eventDeltas
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?array $eventDeltas = null,
        ?array $betas = null
    ): self {
        $self = new self;

        null !== $eventDeltas && $self['eventDeltas'] = $eventDeltas;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * When set, this connection also receives streaming deltas (`event_start`, `event_delta`) while an event is being produced, before the event itself arrives. Deltas are best-effort; when the final event is produced it carries the complete content. A model request that ends early (an error or interrupt) produces no final event — its terminal `span.model_request_end` closes the preview. Accepts one or more event types to preview and may be repeated: `agent.message` streams `content_delta` fragments; `agent.thinking` is start-only — a signal that the agent has begun extended thinking, concluded by the `agent.thinking` event itself. Only previews of the requested event types are sent.
     *
     * @param list<BetaManagedAgentsDeltaType|value-of<BetaManagedAgentsDeltaType>> $eventDeltas
     */
    public function withEventDeltas(array $eventDeltas): self
    {
        $self = clone $this;
        $self['eventDeltas'] = $eventDeltas;

        return $self;
    }

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
