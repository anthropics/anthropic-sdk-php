<?php

namespace Anthropic;

use Anthropic\Core\Concerns\SdkStream;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\Util;
use Anthropic\ErrorType;

/**
 * @template TItem
 *
 * @implements BaseStream<TItem>
 */
final class SSEStream implements BaseStream
{
    /**
     * @use SdkStream<array{
     *   event?: string|null, data?: string|null, id?: string|null, retry?: int|null
     * },
     * TItem,>
     */
    use SdkStream;

    private function parsedGenerator(): \Generator
    {
        if (!$this->stream->valid()) {
            return;
        }

        foreach ($this->stream as $row) {
            switch ($row['event'] ?? null) {
                case 'completion':
                case 'message_start':
                case 'message_delta':
                case 'message_stop':
                case 'content_block_start':
                case 'content_block_delta':
                case 'content_block_stop':
                case 'message':
                case 'user.message':
                case 'user.interrupt':
                case 'user.tool_confirmation':
                case 'user.custom_tool_result':
                case 'agent.message':
                case 'agent.thinking':
                case 'agent.tool_use':
                case 'agent.tool_result':
                case 'agent.mcp_tool_use':
                case 'agent.mcp_tool_result':
                case 'agent.custom_tool_use':
                case 'agent.thread_context_compacted':
                case 'session.status_running':
                case 'session.status_idle':
                case 'session.status_rescheduled':
                case 'session.status_terminated':
                case 'session.error':
                case 'session.deleted':
                case 'span.model_request_start':
                case 'span.model_request_end':
                    if ($data = $row['data'] ?? '') {
                        $decoded = Util::decodeJson($data);

                        yield Conversion::coerce($this->convert, value: $decoded);
                    }

                    break;

                case 'ping': break;

                case 'error':
                    if ($data = $row['data'] ?? '') {
                        $json = Util::decodeJson($data);
                        $message = Util::prettyEncodeJson($json);

                        $errorType = Util::dig(Util::dig($json, 'error'), 'type');
                        $type = is_string($errorType) ? ErrorType::tryFrom($errorType) : null;

                        throw APIStatusException::from(
                            request: $this->request,
                            response: $this->response,
                            message: $message,
                            type: $type,
                        );
                    }

                    break;
            }
        }
    }
}
