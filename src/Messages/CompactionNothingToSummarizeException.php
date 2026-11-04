<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * `messages` holds no `user` or `assistant` content to summarize or adopt.
 */
final class CompactionNothingToSummarizeException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Nothing To Summarize Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_nothing_to_summarize'
     */
    public function getErrorCode(): string
    {
        return 'compaction_nothing_to_summarize';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionNothingToSummarizeErrorDetails
    {
        $details = Conversion::coerce(
            CompactionNothingToSummarizeErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionNothingToSummarizeErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
