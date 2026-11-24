<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Anthropic has not approved customer-managed encryption keys for the organization, project or user profile this request applies to, or has paused or withdrawn its approval. If you did not expect this, contact Anthropic.
 */
final class BetaCMEKNotApprovedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta CMEK Not Approved Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cmek_not_approved'
     */
    public function getErrorCode(): string
    {
        return 'cmek_not_approved';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaCMEKNotApprovedErrorDetails
    {
        $details = Conversion::coerce(
            BetaCMEKNotApprovedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaCMEKNotApprovedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
