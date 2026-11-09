<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The organization cannot retrieve, set or delete spend limits with an Admin API credential.
 */
final class SpendLimitsAdminAPIWritesNotEnabledException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Spend Limits Admin API Writes Not Enabled Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'spend_limits_admin_api_writes_not_enabled'
     */
    public function getErrorCode(): string
    {
        return 'spend_limits_admin_api_writes_not_enabled';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): SpendLimitsAdminAPIWritesNotEnabledErrorDetails
    {
        $details = Conversion::coerce(
            SpendLimitsAdminAPIWritesNotEnabledErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof SpendLimitsAdminAPIWritesNotEnabledErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
