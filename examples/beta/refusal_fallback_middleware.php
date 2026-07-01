#!/usr/bin/env php

<?php

require_once dirname(__DIR__, 2).'/vendor/autoload.php';

use Anthropic\Beta\Messages\BetaFallbackBlock;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaTextDelta;
use Anthropic\Client;
use Anthropic\Lib\Middleware\BetaFallbackState;
use Anthropic\Lib\Middleware\RefusalFallbackMiddleware;

$apiKey = getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key';

// 1. Server-side fallbacks (preferred): the API retries a refusal itself —
// one request, a plain client, no client-side logic. Use this when talking
// to the API directly.
$client = new Client(apiKey: $apiKey);

$served = $client->beta->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Some prompt that triggers a refusal']],
    model: 'claude-fable-5',
    fallbacks: [['model' => 'claude-opus-4-8']],
    betas: ['server-side-fallback-2026-06-01'],
);
echo "server-side, served by: {$served->model}\n";

// If your provider doesn't support server-side fallbacks, register the
// client-side middleware instead:
$fallbackClient = new Client(
    apiKey: $apiKey,
    requestOptions: [
        'middleware' => [new RefusalFallbackMiddleware([['model' => 'claude-opus-4-8']])],
    ],
);
$state = new BetaFallbackState; // pins follow-ups to the model that accepted

// 2. Streaming: on a refusal the middleware retries and splices the
// fallback's events onto the open stream — one continuous message, with a
// `fallback` content block marking the model boundary.
$stream = $fallbackClient->beta->messages->createStream(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Some prompt that triggers a refusal']],
    model: 'claude-fable-5',
    requestOptions: ['fallbackState' => $state],
);

foreach ($stream as $event) {
    if ($event instanceof BetaRawContentBlockDeltaEvent && $event->delta instanceof BetaTextDelta) {
        echo $event->delta->text;
    }
    if ($event instanceof BetaRawContentBlockStartEvent && $event->contentBlock instanceof BetaFallbackBlock) {
        $block = $event->contentBlock;
        echo "\n--- fell back: {$block->from->model} -> {$block->to->model} ---\n";
    }
}
echo "\n";

// 3. Non-streaming: same middleware, the retry just happens before you get
// the message back. Reusing the state keeps the conversation pinned to the
// model that accepted.
$followUp = $fallbackClient->beta->messages->create(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Some prompt that triggers a refusal']],
    model: 'claude-fable-5',
    requestOptions: ['fallbackState' => $state],
);
echo "non-streaming, served by: {$followUp->model}\n";
