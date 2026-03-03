#!/usr/bin/env php

<?php

/**
 * Streaming Structured Output Example
 *
 * This example demonstrates how to use structured outputs with streaming.
 * When streaming, you can watch the JSON being built in real-time and then
 * parse the final accumulated result into your model classes.
 *
 * For a comprehensive guide to structured outputs (including non-streaming),
 * see messages_structured_output.php
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Anthropic\Client;
use Anthropic\Core\Attributes\Required;
use Anthropic\Lib\Attributes\Constrained;
use Anthropic\Lib\Concerns\StructuredOutputModelTrait;
use Anthropic\Lib\Contracts\StructuredOutputModel;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawContentBlockStopEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;

// Define models for the structured output
class Book implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(description: 'Title of the book')]
    public string $title;

    #[Constrained(description: 'Author\'s name')]
    public string $author;

    #[Constrained(description: 'Publication year')]
    public int $year;

    #[Constrained(description: 'Brief summary of the book')]
    public string $summary;

    #[Required(enum: ['fiction', 'non-fiction', 'science', 'history', 'philosophy'])]
    #[Constrained(description: 'Genre')]
    public string $genre;
}

class BookList implements StructuredOutputModel
{
    use StructuredOutputModelTrait;

    #[Constrained(description: 'List of recommended books', itemClass: Book::class, minItems: 1)]
    public array $books;

    public static function description(): ?string
    {
        return 'A curated list of book recommendations';
    }
}

$client = new Client(
    apiKey: getenv('ANTHROPIC_API_KEY') ?: 'my-anthropic-api-key'
);

echo "=== Streaming Structured Output ===\n\n";
echo "Requesting book recommendations from Claude...\n";
echo "Watch the JSON being built in real-time:\n\n";

$stream = $client->messages->createStream(
    maxTokens: 2048,
    messages: [
        [
            'role' => 'user',
            'content' => 'Recommend 3 classic books that everyone should read. Include a mix of genres.',
        ],
    ],
    model: 'claude-sonnet-4-5-20250929',
    outputConfig: ['format' => BookList::class]
);

$accumulatedText = '';
$messageId = null;

foreach ($stream as $event) {
    switch (true) {
        case $event instanceof RawMessageStartEvent:
            $messageId = $event->message->id;
            echo "[Stream started: {$messageId}]\n\n";
            break;

        case $event instanceof RawContentBlockStartEvent:
            echo "[Content block {$event->index} started]\n";
            break;

        case $event instanceof RawContentBlockDeltaEvent:
            if (isset($event->delta->text)) {
                // Stream the JSON as it arrives
                echo $event->delta->text;
                flush();
                $accumulatedText .= $event->delta->text;
            }
            break;

        case $event instanceof RawContentBlockStopEvent:
            echo "\n[Content block {$event->index} complete]\n";
            break;

        case $event instanceof RawMessageStopEvent:
            echo "\n[Stream complete]\n";
            break;
    }
}

// Parse the accumulated JSON into our model
echo "\n" . str_repeat('=', 60) . "\n";
echo "Parsing accumulated JSON into BookList model...\n";
echo str_repeat('=', 60) . "\n\n";

try {
    $json = json_decode($accumulatedText, true, 512, JSON_THROW_ON_ERROR);
    $bookList = BookList::fromArray($json);

    echo "Found " . count($bookList->books) . " book recommendations:\n\n";

    foreach ($bookList->books as $i => $book) {
        echo ($i + 1) . ". {$book->title}\n";
        echo "   Author: {$book->author}\n";
        echo "   Year: {$book->year}\n";
        echo "   Genre: {$book->genre}\n";
        echo "   Summary: {$book->summary}\n";
        echo "\n";
    }

    // Demonstrate serialization back to JSON
    echo str_repeat('=', 60) . "\n";
    echo "Model can be serialized back to JSON:\n";
    echo str_repeat('=', 60) . "\n";
    echo $bookList->toJson() . "\n";

} catch (\JsonException $e) {
    echo "Error parsing JSON: {$e->getMessage()}\n";
    echo "Raw accumulated text:\n{$accumulatedText}\n";
}
