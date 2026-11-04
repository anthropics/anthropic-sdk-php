<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * `messages` holds more than one `compaction` block with content. Send only the block the conversation returned last.
 */
final class CompactionBlockAmbiguousException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Block Ambiguous Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_block_ambiguous'
     */
    public function getErrorCode(): string
    {
        return 'compaction_block_ambiguous';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionBlockAmbiguousErrorDetails
    {
        $details = Conversion::coerce(
            CompactionBlockAmbiguousErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionBlockAmbiguousErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
