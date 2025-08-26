<?php

namespace Anthropic\Core\Streaming;

use Anthropic\Core\Conversion;
use Anthropic\Core\Errors\APIStatusError;
use Anthropic\Core\Util;

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
                        $decoded = Util::decodeJson($chunk['data']);

                        yield Conversion::coerce($this->convert, value: $decoded);
                    }

                    break;

                case 'ping': break;

                case 'error':
                    if (isset($chunk['data'])) {
                        $json = Util::decodeJson($chunk['data']);
                        $message = Util::prettyEncodeJson($json);

                        $exn = APIStatusError::from(
                            request: $this->request,
                            response: $this->response,
                            message: $message,
                        );

                        throw $exn;
                    }

                    break;
            }
        }
    }
}
