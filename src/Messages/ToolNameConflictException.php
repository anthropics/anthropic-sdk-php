<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * A tool made available in `messages` takes a name that an available tool of another kind, or of another MCP server, already holds.
 */
final class ToolNameConflictException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Tool Name Conflict Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'tool_name_conflict'
     */
    public function getErrorCode(): string
    {
        return 'tool_name_conflict';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ToolNameConflictErrorDetails
    {
        $details = Conversion::coerce(
            ToolNameConflictErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ToolNameConflictErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
