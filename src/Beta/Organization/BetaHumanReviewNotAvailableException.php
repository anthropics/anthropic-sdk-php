<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Human review can't be set as requested on this Workspace, so the request changed nothing. The error's `message` says what to do instead.
 */
final class BetaHumanReviewNotAvailableException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Human Review Not Available Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'human_review_not_available'
     */
    public function getErrorCode(): string
    {
        return 'human_review_not_available';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaHumanReviewNotAvailableErrorDetails
    {
        $details = Conversion::coerce(
            BetaHumanReviewNotAvailableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaHumanReviewNotAvailableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
