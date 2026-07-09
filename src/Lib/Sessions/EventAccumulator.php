<?php

declare(strict_types=1);

namespace Anthropic\Lib\Sessions;

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentMessagePreview;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;
use Anthropic\Core\Exceptions\AnthropicException;

/**
 * Folds one session stream event into an `agent.message` snapshot. Deltas are
 * lossy previews; the buffered `agent.message` event is canonical. The caller
 * owns the per-event-id map of snapshots:
 *
 * ```php
 * $messages = [];
 * foreach ($stream as $event) {
 *     if ($event instanceof BetaManagedAgentsStartEvent && $event->event instanceof BetaManagedAgentsAgentMessagePreview) {
 *         $messages[$event->event->id] = EventAccumulator::accumulate($messages[$event->event->id] ?? null, $event);
 *     } elseif ($event instanceof BetaManagedAgentsDeltaEvent) {
 *         if (isset($messages[$event->eventID])) { // drops deltas for previews already closed
 *             $messages[$event->eventID] = EventAccumulator::accumulate($messages[$event->eventID], $event);
 *         }
 *     } elseif ($event instanceof ManagedAgentsAgentMessageEvent) {
 *         $messages[$event->id] = EventAccumulator::accumulate($messages[$event->id] ?? null, $event); // canonical
 *     } elseif ($event instanceof ManagedAgentsSpanModelRequestEndEvent) {
 *         $messages = EventAccumulator::closeOpenPreviews($messages);
 *     }
 * }
 * ```
 *
 * @phpstan-import-type ManagedAgentsStreamSessionEventsVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsStreamSessionEvents
 */
final class EventAccumulator
{
    /**
     * Fold one event into the accumulated snapshot. Never mutates its inputs —
     * a delta returns a fresh snapshot.
     *
     * - `event_start` for an `agent.message` preview returns a fresh empty
     *   snapshot (placeholder epoch `processedAt` until the buffered event
     *   replaces it), unless the snapshot is already the reconciled canonical
     *   event, which is kept; other previews return `$accumulated` unchanged.
     * - `event_delta` folds the fragment in: a new `index` inserts it as a
     *   fresh content entry; an existing index appends to that entry. An
     *   unrecognised fragment type on an existing index is a no-op — deltas
     *   are best-effort and the buffered event is canonical. A straggler
     *   delta arriving after the canonical event is dropped.
     * - A top-level `agent.message` is the buffered canonical event: it is
     *   returned as-is, replacing whatever the preview had accumulated.
     * - Anything else returns `$accumulated` unchanged.
     *
     * @param ManagedAgentsAgentMessageEvent|null $accumulated the snapshot so far for this event id
     * @param ManagedAgentsStreamSessionEventsVariants|mixed $event any event from a session stream
     *
     * @throws AnthropicException on an `event_delta` whose `event_start` was
     *                            never seen, or whose index skips past the end of the accumulated
     *                            content
     */
    public static function accumulate(
        ?ManagedAgentsAgentMessageEvent $accumulated,
        mixed $event,
    ): ?ManagedAgentsAgentMessageEvent {
        if ($event instanceof BetaManagedAgentsStartEvent) {
            if ($event->event instanceof BetaManagedAgentsAgentMessagePreview) {
                if (null !== $accumulated && self::isReconciled($accumulated)) {
                    return $accumulated;
                }

                return ManagedAgentsAgentMessageEvent::with(
                    id: $event->event->id,
                    content: [],
                    processedAt: new \DateTimeImmutable('@0'),
                    type: 'agent.message',
                );
            }

            return $accumulated;
        }

        if ($event instanceof ManagedAgentsAgentMessageEvent) {
            return $event;
        }

        if ($event instanceof BetaManagedAgentsDeltaEvent) {
            if (null === $accumulated) {
                throw new AnthropicException(
                    "event_delta for {$event->eventID} received before its event_start"
                );
            }

            if (self::isReconciled($accumulated)) {
                return $accumulated;
            }

            $content = $accumulated->content;
            $idx = $event->delta->index ?? 0;
            $fragment = $event->delta->content;

            // Indices arrive in order — the first delta at a new index opens the
            // slot. A gap means deltas arrived out of order or were mis-routed.
            if ($idx < 0 || $idx > \count($content)) {
                throw new AnthropicException(
                    sprintf(
                        'event_delta index %d is beyond the end of content (length %d)',
                        $idx,
                        \count($content),
                    )
                );
            }

            if ($idx === \count($content)) {
                $content[] = clone $fragment;
            } elseif ('text' === $fragment['type'] && 'text' === $content[$idx]['type']) {
                $updated = $content[$idx]->withText($content[$idx]->text.$fragment->text);
                array_splice($content, $idx, 1, [$updated]);
            } else {
                return $accumulated;
            }

            return $accumulated->withContent($content);
        }

        return $accumulated;
    }

    /**
     * Drop snapshots still waiting on their buffered `agent.message`. Call on
     * `span.model_request_end`: the request is over (completed, errored, or
     * interrupted), so no buffered event is coming for its open previews.
     * Reconciled canonical events survive.
     *
     * @param array<string, ManagedAgentsAgentMessageEvent> $messages the per-event-id map of snapshots
     *
     * @return array<string, ManagedAgentsAgentMessageEvent>
     */
    public static function closeOpenPreviews(array $messages): array
    {
        return array_filter($messages, self::isReconciled(...));
    }

    /**
     * Preview snapshots carry the placeholder epoch `processedAt`; the
     * buffered canonical event always has a real timestamp.
     */
    private static function isReconciled(ManagedAgentsAgentMessageEvent $message): bool
    {
        return 0 !== $message->processedAt->getTimestamp();
    }
}
