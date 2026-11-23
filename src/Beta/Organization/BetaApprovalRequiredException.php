<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Turning human review off needs Anthropic's approval for the organization, and the organization doesn't have it. Contact Anthropic support to request approval.
 */
final class BetaApprovalRequiredException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Approval Required Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'approval_required'
     */
    public function getErrorCode(): string
    {
        return 'approval_required';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaApprovalRequiredErrorDetails
    {
        $details = Conversion::coerce(
            BetaApprovalRequiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaApprovalRequiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
