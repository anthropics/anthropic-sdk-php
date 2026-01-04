#!/usr/bin/env php

<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

$stream = $client->messages->createStream(
    maxTokens: 1024,
    messages: [['role' => 'user', 'content' => 'Hello, Claude']],
    model: 'claude-sonnet-4-20250514'
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
