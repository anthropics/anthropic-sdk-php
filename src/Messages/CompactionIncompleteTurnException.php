<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The compaction request ends on an `assistant` turn that is not finished.
 */
final class CompactionIncompleteTurnException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Compaction Incomplete Turn Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'compaction_incomplete_turn'
     */
    public function getErrorCode(): string
    {
        return 'compaction_incomplete_turn';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CompactionIncompleteTurnErrorDetails
    {
        $details = Conversion::coerce(
            CompactionIncompleteTurnErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CompactionIncompleteTurnErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
