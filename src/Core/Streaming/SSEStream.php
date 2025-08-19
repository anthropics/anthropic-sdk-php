<?php

namespace Anthropic\Core\Streaming;

use Anthropic\Core\Conversion;

/**
 * @template TItem
 *
 * @extends BaseStream<
 *   array{
 *     event?: null|string, data?: null|string, id?: null|string, retry?: null|int
 *   },
 *   TItem,
 * >
 */
final class SSEStream extends BaseStream
{
    public function parsedGenerator(\Generator $rawStream): \Generator
    {
        foreach ($rawStream as $chunk) {
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
