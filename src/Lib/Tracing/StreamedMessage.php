<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tracing;

use Anthropic\Lib\Streaming\MessageAccumulator;

/**
 * What the events of a streamed response say about the Message, as far as they have been read, kept for the span's
 * response attributes: the `message_start` Message with the usage and stop reason that `message_delta` updates and the
 * model that a `fallback` content block names, whether `message_delta` and `message_stop` were read, and whether the
 * stream was read to its end. The content blocks are kept only in content mode, by `$accumulator`.
 *
 * @internal
 */
final class StreamedMessage
{
    /** The events that {@see self::add()} reads. The others only carry content. */
    public const EVENT_TYPES = ['message_start', 'content_block_start', 'message_delta', 'message_stop'];

    /** @var array<mixed>|null */
    public ?array $message = null;

    /** @var array<mixed> */
    public array $usage = [];

    /**
     * The SDK's own accumulator of the events read, for the span's output content. Null outside content mode, before
     * the first event, and once it has rejected an event: no output content is better than a wrong one.
     */
    public ?MessageAccumulator $accumulator = null;

    /** Whether a `message_delta` was read: the stop reason and the output tokens are the response's, not the placeholders of `message_start`. */
    public bool $finalized = false;

    /** Whether `message_stop` was read: the response is complete. */
    public bool $stopped = false;

    /** Whether the stream was read to the end of the response body: the API closed it, not the application. */
    public bool $ended = false;

    /**
     * Adds `$event`, the next event read, in the API's shape. Returns whether it changed what is kept: one of
     * {@see self::EVENT_TYPES} does, and `content_block_start` only when its block is a `fallback` one.
     */
    public function add(mixed $event): bool
    {
        if (!is_array($event)) {
            return false;
        }

        switch ($event['type'] ?? null) {
            case 'message_start':
                $message = self::wire($event['message'] ?? null);
                $this->message = is_array($message) ? $message : [];
                $usage = self::wire($this->message['usage'] ?? null);
                $this->usage = is_array($usage) ? $usage : [];

                return true;

            case 'content_block_start':
                $block = self::wire($event['content_block'] ?? null);
                if (null === $this->message || !is_array($block) || 'fallback' !== ($block['type'] ?? null)) {
                    break;
                }
                // The model that serves the rest of the response, as the SDK's own accumulator keeps it.
                $to = self::wire($block['to'] ?? null);
                if (is_array($to) && null !== ($to['model'] ?? null)) {
                    $this->message['model'] = $to['model'];
                }

                return true;

            case 'message_delta':
                if (null === $this->message) {
                    break;
                }
                $usage = self::wire($event['usage'] ?? null);
                foreach (is_array($usage) ? $usage : [] as $key => $value) {
                    // The cache writes by lifetime come from `message_start` only.
                    if (null !== $value && 'cache_creation' !== $key) {
                        $this->usage[$key] = $value;
                    }
                }
                $delta = self::wire($event['delta'] ?? null);
                if (is_array($delta) && null !== ($delta['stop_reason'] ?? null)) {
                    $this->message['stop_reason'] = $delta['stop_reason'];
                }
                $this->finalized = true;

                return true;

            case 'message_stop':
                $this->stopped = true;

                return true;
        }

        return false;
    }

    /**
     * `$value` in the API's shape: a model becomes what it serializes to, and an object its properties.
     */
    private static function wire(mixed $value): mixed
    {
        if ($value instanceof \JsonSerializable) {
            $value = $value->jsonSerialize();
        }

        return is_object($value) ? get_object_vars($value) : $value;
    }
}
