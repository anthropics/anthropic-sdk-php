<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * A tool change or MCP tool listing references a tool or MCP server that is not defined at that position in the conversation.
 */
final class ToolReferenceUnresolvedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Tool Reference Unresolved Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'tool_reference_unresolved'
     */
    public function getErrorCode(): string
    {
        return 'tool_reference_unresolved';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ToolReferenceUnresolvedErrorDetails
    {
        $details = Conversion::coerce(
            ToolReferenceUnresolvedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ToolReferenceUnresolvedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
