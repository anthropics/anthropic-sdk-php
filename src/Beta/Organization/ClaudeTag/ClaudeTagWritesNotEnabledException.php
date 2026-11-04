<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * Changes through the Claude Tag API are not enabled for the organization.
 */
final class ClaudeTagWritesNotEnabledException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Claude Tag Writes Not Enabled Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'claude_tag_writes_not_enabled'
     */
    public function getErrorCode(): string
    {
        return 'claude_tag_writes_not_enabled';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ClaudeTagWritesNotEnabledErrorDetails
    {
        $details = Conversion::coerce(
            ClaudeTagWritesNotEnabledErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ClaudeTagWritesNotEnabledErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
