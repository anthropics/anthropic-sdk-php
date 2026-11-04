<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
 */
final class ClaudeCodeKeyCreatorNotMemberException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Claude Code Key Creator Not Member Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'claude_code_key_creator_not_member'
     */
    public function getErrorCode(): string
    {
        return 'claude_code_key_creator_not_member';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ClaudeCodeKeyCreatorNotMemberErrorDetails
    {
        $details = Conversion::coerce(
            ClaudeCodeKeyCreatorNotMemberErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ClaudeCodeKeyCreatorNotMemberErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
