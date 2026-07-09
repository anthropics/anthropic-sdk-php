#!/usr/bin/env php

<?php

/**
 * Streams a session with `eventDeltas` enabled and folds the `event_start` /
 * `event_delta` previews into `agent.message` snapshots with
 * `EventAccumulator` — the caller owns the per-event-id map of snapshots.
 */

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentMessagePreview;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEndTurn;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent;
use Anthropic\Client;
use Anthropic\Lib\Sessions\EventAccumulator;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

// Create an environment, agent and session.
$environment = $client->beta->environments->create(
    name: 'streaming-deltas-example'
);
echo "Created environment: {$environment->id}\n";

$agent = $client->beta->agents->create(
    name: 'streaming-deltas-example',
    model: 'claude-sonnet-5'
);
echo "Created agent: {$agent->id}\n";

$session = $client->beta->sessions->create(
    agent: ['type' => 'agent', 'id' => $agent->id, 'version' => $agent->version],
    environmentID: $environment->id
);
echo "Created session: {$session->id}\n";

// Send a user message.
$client->beta->sessions->events->send(
    sessionID: $session->id,
    events: [
        [
            'type' => 'user.message',
            'content' => [['type' => 'text', 'text' => 'Write a short haiku about the ocean.']],
        ],
    ]
);

// Open the event stream with `eventDeltas` enabled so `agent.message` text
// arrives incrementally as `event_start` / `event_delta` previews before the
// buffered final event.
$stream = $client->beta->sessions->events->streamStream(
    sessionID: $session->id,
    eventDeltas: ['agent.message']
);

function render_text(ManagedAgentsAgentMessageEvent $message): string
{
    return implode('', array_map(fn ($block) => $block->text, $message->content));
}

// One snapshot per event id: previews grow delta by delta, then the buffered
// `agent.message` replaces them with the canonical content.
/** @var array<string, ManagedAgentsAgentMessageEvent> $messages */
$messages = [];

echo "\nStreaming:\n";
foreach ($stream as $event) {
    if ($event instanceof BetaManagedAgentsStartEvent && $event->event instanceof BetaManagedAgentsAgentMessagePreview) {
        $messages[$event->event->id] = EventAccumulator::accumulate($messages[$event->event->id] ?? null, $event);
    } elseif ($event instanceof BetaManagedAgentsDeltaEvent) {
        // Deltas are ephemeral best-effort previews; one whose snapshot was
        // already closed is stale — drop it.
        if (isset($messages[$event->eventID])) {
            $messages[$event->eventID] = EventAccumulator::accumulate($messages[$event->eventID], $event);
            echo "\r".render_text($messages[$event->eventID]);
        }
    } elseif ($event instanceof ManagedAgentsAgentMessageEvent) {
        // The buffered event is canonical — it replaces whatever the preview accumulated.
        $messages[$event->id] = EventAccumulator::accumulate($messages[$event->id] ?? null, $event);
        echo "\n[final] ".render_text($event)."\n";
    } elseif ($event instanceof ManagedAgentsSpanModelRequestEndEvent) {
        // The request is over — no buffered event is coming for its open
        // previews, so drop them; reconciled canonical messages survive.
        $messages = EventAccumulator::closeOpenPreviews($messages);
    } elseif ($event instanceof ManagedAgentsSessionStatusIdleEvent) {
        if ($event->stopReason instanceof ManagedAgentsSessionEndTurn) {
            break;
        }
    } elseif ($event instanceof ManagedAgentsSessionErrorEvent) {
        fwrite(STDERR, "[error] {$event->error->type}: {$event->error->message}\n");
        break;
    }
}

// Canonical messages persist across `span.model_request_end`.
echo "\nAccumulated messages:\n";
foreach ($messages as $id => $message) {
    echo "  {$id}: ".render_text($message)."\n";
}
