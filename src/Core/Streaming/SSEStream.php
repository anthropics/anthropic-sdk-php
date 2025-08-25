<?php

namespace Anthropic\Core\Streaming;

use Anthropic\Core\Conversion;

/**
 * @template TItem
 *
 * @extends AbstractStream<
 *   array{
 *     event?: string|null, data?: string|null, id?: string|null, retry?: int|null
 *   },
 *   TItem,
 * >
 */
final class SSEStream extends AbstractStream
{
    protected function parsedGenerator(): \Generator
    {
        if (!$this->stream->valid()) {
            return;
        }
        foreach ($this->stream as $chunk) {
            switch ($chunk['event'] ?? '') {
                case 'completion':
                case 'message_start':
                case 'message_delta':
                case 'message_stop':
                case 'content_block_start':
                case 'content_block_delta':
                case 'content_block_stop':
                    if (isset($chunk['data'])) {
                        $decoded = json_decode($chunk['data'], associative: true, flags: JSON_THROW_ON_ERROR);

                        yield Conversion::coerce($this->decodeTarget, value: $decoded);
                    }

                    break;

                case 'ping': break;

                case 'error':
                    if (isset($chunk['data'])) {
                        $message = json_encode(json_decode($chunk['data']), JSON_PRETTY_PRINT) ?: '';

                        throw new \RuntimeException($message);
                    }

                    break;
            }
        }
    }
}
