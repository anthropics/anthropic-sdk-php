<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The conversation references more distinct tools than a `compaction` block can record.
 */
final class CompactionTooManyToolReferencesException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Too Many Tool References Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_too_many_tool_references'
     */
    public function getErrorCode(): string
    {
        return 'compaction_too_many_tool_references';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionTooManyToolReferencesErrorDetails
    {
        $details = Conversion::coerce(
            CompactionTooManyToolReferencesErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionTooManyToolReferencesErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
