<?php

declare(strict_types=1);

namespace Anthropic\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ServiceUnavailableException;
use Anthropic\Core\Util;

/**
 * Some of the request's changes may have been saved and others not. Send the same request again to finish it; changes already saved aren't repeated.
 */
final class ChangeOutcomeUnknownException extends ServiceUnavailableException
{
    /** @var string */
    protected const DESC = 'Anthropic Change Outcome Unknown Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'change_outcome_unknown'
     */
    public function getErrorCode(): string
    {
        return 'change_outcome_unknown';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ChangeOutcomeUnknownErrorDetails
    {
        $details = Conversion::coerce(
            ChangeOutcomeUnknownErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ChangeOutcomeUnknownErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
