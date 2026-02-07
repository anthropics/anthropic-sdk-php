<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Foundry;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;

$client = Foundry\Client::fromEnvironment(
    baseUrl: 'https://example-resource.services.ai.azure.com/anthropic'
);

$stream = $client->messages->createStream(
    maxTokens: 1024,
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
    model: 'claude-haiku-4-5',
);

foreach ($stream as $event) {
    switch (true) {
        case $event instanceof RawMessageStartEvent:
            var_dump($event->message);

            break;

        case $event instanceof RawMessageDeltaEvent:
            var_dump($event->delta);

            break;

        case $event instanceof RawMessageStopEvent:
            var_dump($event->toProperties());

            break;

        case $event instanceof RawContentBlockStartEvent:
            var_dump($event->contentBlock);

            break;

        case $event instanceof RawContentBlockDeltaEvent:
            var_dump($event->delta);

            break;

        default:
            var_dump($event->type);

            break;
    }
}
