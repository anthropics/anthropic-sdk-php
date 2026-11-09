<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The `compaction` block is not the first block of the conversation, or is in a `system` message.
 */
final class CompactionBlockMisplacedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Block Misplaced Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_block_misplaced'
     */
    public function getErrorCode(): string
    {
        return 'compaction_block_misplaced';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionBlockMisplacedErrorDetails
    {
        $details = Conversion::coerce(
            CompactionBlockMisplacedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionBlockMisplacedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
