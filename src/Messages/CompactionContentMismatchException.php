<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The `compaction` block's `content` differs from the text its `signature` recorded.
 */
final class CompactionContentMismatchException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Content Mismatch Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_content_mismatch'
     */
    public function getErrorCode(): string
    {
        return 'compaction_content_mismatch';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionContentMismatchErrorDetails
    {
        $details = Conversion::coerce(
            CompactionContentMismatchErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionContentMismatchErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
