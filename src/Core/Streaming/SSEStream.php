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
                        $parsed = json_decode($chunk['data'], true);

                        yield Conversion::coerce($this->decodeTarget, $parsed);
                    }

                    break;

                case 'ping': break;

                case 'error': throw new \Exception; // TODO improve this error
            }
        }
    }
}
