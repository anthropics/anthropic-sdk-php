<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Anthropic has not approved keeping data in a customer-owned storage bucket for the organization, project or user profile this request applies to, or has paused or withdrawn its approval. If you did not expect this, contact Anthropic.
 */
final class BetaStorageNotApprovedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Storage Not Approved Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_not_approved'
     */
    public function getErrorCode(): string
    {
        return 'storage_not_approved';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaStorageNotApprovedErrorDetails
    {
        $details = Conversion::coerce(
            BetaStorageNotApprovedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaStorageNotApprovedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
