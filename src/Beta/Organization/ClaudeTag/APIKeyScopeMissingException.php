<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The API key lacks the scope the request needs: `read:claude_tag` for a read, `write:claude_tag` for a change.
 */
final class APIKeyScopeMissingException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic API Key Scope Missing Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'api_key_scope_missing'
     */
    public function getErrorCode(): string
    {
        return 'api_key_scope_missing';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): APIKeyScopeMissingErrorDetails
    {
        $details = Conversion::coerce(
            APIKeyScopeMissingErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof APIKeyScopeMissingErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
