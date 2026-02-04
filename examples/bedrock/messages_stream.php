<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Anthropic\Bedrock;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;

// Discover and create a Bedrock client from the current environment (e.g. Environment variables, EC2 instance profile)
$client = Bedrock\Client::fromEnvironment();

$stream = $client->messages->createStream(
    model: 'anthropic.claude-3-haiku-20240307-v1:0',
    maxTokens: 1024,
    messages: [
        [
            'role' => 'user',
            'content' => 'Hello, Claude!',
        ],
    ],
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
