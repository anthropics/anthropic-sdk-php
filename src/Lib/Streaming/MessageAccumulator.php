<?php

declare(strict_types=1);

namespace Anthropic\Lib\Streaming;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Core\Conversion;
use Anthropic\Messages\Message;

/**
 * Folds a stream of raw message events into the message they accumulate to,
 * mirroring the accumulators in the other Anthropic SDKs (Go's
 * `Message.Accumulate`, TypeScript's `MessageStream` snapshots).
 *
 * ```php
 * $accumulator = new MessageAccumulator;
 * foreach ($client->messages->createStream(...) as $event) {
 *     $accumulator->accumulate($event);
 * }
 * $message = $accumulator->message();
 * ```
 *
 * Accumulation semantics (shared across SDKs):
 * - `message_start` seeds the snapshot with the start message.
 * - `text_delta`/`thinking_delta`/`signature_delta` append to their block.
 * - `input_json_delta` chunks concatenate into a buffer that is decoded into
 *   the block's `input` when the block completes; until then the snapshot
 *   keeps the start event's `{}` placeholder.
 * - `citations_delta` appends to the block's `citations` list.
 * - `message_delta` overwrites `stop_reason`/`stop_sequence`, replaces
 *   `stop_details` when present, always replaces `usage.output_tokens` (the
 *   API streams cumulative totals), and replaces other usage fields only
 *   when present — fields reported at `message_start` are preserved.
 *
 * Event-order violations throw: an event before `message_start`, a second
 * `message_start`, a `content_block_start` that skips an index, or a delta
 * addressing a block that does not exist.
 */
final class MessageAccumulator
{
    /** @var array<string,mixed>|null the accumulated message, in wire shape */
    private ?array $snapshot = null;

    /** @var array<int,string> per-block buffers of concatenated input_json_delta chunks */
    private array $inputBuffers = [];

    private bool $complete = false;

    private function __construct(
        /** @var class-string<Message|BetaMessage> */
        private readonly string $convert,
    ) {}

    public static function forMessages(): self
    {
        return new self(Message::class);
    }

    public static function forBetaMessages(): self
    {
        return new self(BetaMessage::class);
    }

    /**
     * Folds one raw stream event into the snapshot. Accepts the typed event
     * models yielded by the SDK's streams, or plain decoded event arrays.
     *
     * @throws \LogicException on out-of-order events
     */
    public function accumulate(mixed $event): self
    {
        $event = self::wireShape($event);
        $type = $event['type'] ?? null;
        if (is_null($event) || !is_string($type)) {
            throw new \LogicException('cannot accumulate an event without a type');
        }

        if ('message_start' === $type) {
            if (!is_null($this->snapshot)) {
                throw new \LogicException('unexpected event order: got "message_start" before receiving "message_stop"');
            }

            $this->snapshot = self::wireShape($event['message'] ?? null)
                ?? throw new \LogicException('"message_start" event carried no message');

            return $this;
        }

        if ('ping' === $type) {
            return $this;
        }

        if (is_null($this->snapshot)) {
            throw new \LogicException("unexpected event order: got \"{$type}\" before \"message_start\"");
        }

        match ($type) {
            'message_delta' => $this->applyMessageDelta($event),
            'content_block_start' => $this->startContentBlock($event),
            'content_block_delta' => $this->applyContentBlockDelta($event),
            'content_block_stop' => $this->stopContentBlock($event),
            'message_stop' => $this->complete = true,
            default => null, // unknown event types are ignored, like the other SDKs
        };

        return $this;
    }

    /**
     * The accumulated message so far, as the SDK's typed model. After
     * `message_stop` this is the complete message; mid-stream it is a
     * snapshot (with any in-flight tool input still the `{}` placeholder).
     */
    public function message(): Message|BetaMessage
    {
        if (is_null($this->snapshot)) {
            throw new \LogicException('cannot build a message before a "message_start" event was accumulated');
        }

        $snapshot = $this->snapshot;
        $content = $snapshot['content'] ?? null;
        if (is_array($content)) {
            foreach ($this->inputBuffers as $index => $buffer) {
                // an incomplete buffer (stream still mid-block) decodes to
                // null and the start event's placeholder stays
                $decoded = json_decode($buffer, associative: true);
                $block = $content[$index] ?? null;
                if (!is_null($decoded) && is_array($block)) {
                    $block['input'] = $decoded;
                    $content[$index] = $block;
                }
            }
            $snapshot['content'] = $content;
        }

        $message = Conversion::coerce($this->convert, value: $snapshot);
        assert($message instanceof Message || $message instanceof BetaMessage);

        return $message;
    }

    /**
     * Whether a `message_stop` event has been accumulated.
     */
    public function isComplete(): bool
    {
        return $this->complete;
    }

    /** @param array<string,mixed> $event */
    private function applyMessageDelta(array $event): void
    {
        $snapshot = $this->snapshot ?? [];
        $delta = self::wireShape($event['delta'] ?? null) ?? [];

        // stop_reason and stop_sequence overwrite unconditionally;
        // stop_details only replaces when the delta carries one
        $snapshot['stop_reason'] = $delta['stop_reason'] ?? null;
        $snapshot['stop_sequence'] = $delta['stop_sequence'] ?? null;
        if (!is_null($delta['stop_details'] ?? null)) {
            $snapshot['stop_details'] = $delta['stop_details'];
        }

        $usage = self::wireShape($event['usage'] ?? null) ?? [];
        $accumulated = self::wireShape($snapshot['usage'] ?? null) ?? [];

        // output_tokens is a cumulative total and always replaces; the other
        // usage fields replace only when present, preserving message_start's
        $accumulated['output_tokens'] = $usage['output_tokens'] ?? 0;
        foreach ($usage as $field => $value) {
            if ('output_tokens' !== $field && !is_null($value)) {
                $accumulated[$field] = $value;
            }
        }
        $snapshot['usage'] = $accumulated;

        $this->snapshot = $snapshot;
    }

    /** @param array<string,mixed> $event */
    private function startContentBlock(array $event): void
    {
        $content = $this->contentBlocks();
        $index = $event['index'] ?? null;

        // starts arrive in index order with no gaps: a start always
        // addresses the slot right after the previous block
        if ($index !== count($content)) {
            $expected = count($content);

            throw new \LogicException('received "content_block_start" for content block at index '.json_encode($index).", expected index {$expected}");
        }

        $block = self::wireShape($event['content_block'] ?? null) ?? [];
        $content[] = $block;
        $snapshot = $this->snapshot ?? [];
        $snapshot['content'] = $content;

        // the accumulated model is the SERVED model: relabel from each
        // fallback seam block's to.model, last block wins
        if ('fallback' === ($block['type'] ?? null)) {
            $to = self::wireShape($block['to'] ?? null);
            $model = $to['model'] ?? null;
            if (is_string($model) && '' !== $model) {
                $snapshot['model'] = $model;
            }
        }

        $this->snapshot = $snapshot;
    }

    /** @param array<string,mixed> $event */
    private function applyContentBlockDelta(array $event): void
    {
        $index = $this->checkedIndex($event, type: 'content_block_delta');
        $block = self::wireShape($this->contentBlocks()[$index] ?? null) ?? [];

        $delta = self::wireShape($event['delta'] ?? null) ?? [];

        switch ($delta['type'] ?? null) {
            case 'text_delta':
                $block['text'] = self::str($block['text'] ?? null).self::str($delta['text'] ?? null);

                break;

            case 'thinking_delta':
                $block['thinking'] = self::str($block['thinking'] ?? null).self::str($delta['thinking'] ?? null);

                break;

            case 'signature_delta':
                $block['signature'] = self::str($block['signature'] ?? null).self::str($delta['signature'] ?? null);

                break;

            case 'input_json_delta':
                $partial = $delta['partial_json'] ?? '';
                if (is_string($partial) && '' !== $partial) {
                    $this->inputBuffers[$index] = ($this->inputBuffers[$index] ?? '').$partial;
                }

                break;

            case 'citations_delta':
                $citations = $block['citations'] ?? [];
                $citations = is_array($citations) ? $citations : [];
                $citations[] = $delta['citation'] ?? null;
                $block['citations'] = $citations;

                break;

            case 'compaction_delta':
                $block['content'] = self::str($block['content'] ?? null).self::str($delta['content'] ?? null);
                $block['encrypted_content'] = $delta['encrypted_content'] ?? null;

                break;

            default: // unknown delta types are ignored, like the other SDKs
        }

        $this->setContentBlock($index, block: $block);
    }

    /** @param array<string,mixed> $event */
    private function stopContentBlock(array $event): void
    {
        $index = $this->checkedIndex($event, type: 'content_block_stop');

        $buffer = $this->inputBuffers[$index] ?? null;
        if (is_null($buffer)) {
            return;
        }
        unset($this->inputBuffers[$index]);

        $decoded = json_decode($buffer, associative: true);
        if (is_null($decoded)) {
            // a block cut open by a refusal can complete with an incomplete
            // buffer; the start event's placeholder stays
            return;
        }

        $block = self::wireShape($this->contentBlocks()[$index] ?? null) ?? [];
        $block['input'] = $decoded;
        $this->setContentBlock($index, block: $block);
    }

    /** @param array<string,mixed> $block */
    private function setContentBlock(int $index, array $block): void
    {
        $snapshot = $this->snapshot ?? [];
        $content = $snapshot['content'] ?? [];
        if (is_array($content)) {
            $content[$index] = $block;
            $snapshot['content'] = $content;
        }
        $this->snapshot = $snapshot;
    }

    private static function str(mixed $value): string
    {
        return is_string($value) ? $value : '';
    }

    /** @param array<string,mixed> $event */
    private function checkedIndex(array $event, string $type): int
    {
        $content = $this->contentBlocks();
        $index = $event['index'] ?? null;

        if (!is_int($index) || $index < 0 || $index >= count($content)) {
            $count = count($content);

            throw new \LogicException("received \"{$type}\" for content block at index ".json_encode($index)." but there are only {$count} content blocks");
        }

        return $index;
    }

    /** @return list<mixed> */
    private function contentBlocks(): array
    {
        $content = $this->snapshot['content'] ?? [];

        return is_array($content) ? array_values($content) : [];
    }

    /**
     * Normalizes a typed SDK model (or anything JSON-serializable) to its
     * wire-shape array.
     *
     * @return array<string,mixed>|null
     */
    private static function wireShape(mixed $value): ?array
    {
        if ($value instanceof \JsonSerializable) {
            $value = $value->jsonSerialize();
        }
        if (is_object($value)) {
            $value = get_object_vars($value);
        }
        if (!is_array($value)) {
            return null;
        }

        $out = [];
        foreach ($value as $key => $item) {
            $out[strval($key)] = $item;
        }

        return $out;
    }
}
