<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The `compaction` block's `tool_changes` differs from what was returned with the block.
 */
final class CompactionToolChangesMismatchException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Tool Changes Mismatch Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_tool_changes_mismatch'
     */
    public function getErrorCode(): string
    {
        return 'compaction_tool_changes_mismatch';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionToolChangesMismatchErrorDetails
    {
        $details = Conversion::coerce(
            CompactionToolChangesMismatchErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionToolChangesMismatchErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
