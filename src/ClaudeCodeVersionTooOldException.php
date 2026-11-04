<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request comes from a Claude Code version older than the minimum that the requested model or the organization requires. Update Claude Code, then retry.
 */
final class ClaudeCodeVersionTooOldException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Claude Code Version Too Old Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'claude_code_version_too_old'
     */
    public function getErrorCode(): string
    {
        return 'claude_code_version_too_old';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ClaudeCodeVersionTooOldErrorDetails
    {
        $details = Conversion::coerce(
            ClaudeCodeVersionTooOldErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ClaudeCodeVersionTooOldErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
