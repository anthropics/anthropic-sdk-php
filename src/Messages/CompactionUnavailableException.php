<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\OverloadedException;
use Anthropic\Core\Util;

/**
 * The compaction could not be completed for a transient server reason. Retry the request.
 */
final class CompactionUnavailableException extends OverloadedException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Unavailable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_unavailable'
     */
    public function getErrorCode(): string
    {
        return 'compaction_unavailable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionUnavailableErrorDetails
    {
        $details = Conversion::coerce(
            CompactionUnavailableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionUnavailableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
