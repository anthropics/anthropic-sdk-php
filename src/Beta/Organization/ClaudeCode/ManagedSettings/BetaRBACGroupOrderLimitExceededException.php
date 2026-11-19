<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The RBAC Group order already has the most groups allowed. Delete another group's settings first.
 */
final class BetaRBACGroupOrderLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta RBAC Group Order Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'rbac_group_order_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'rbac_group_order_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaRBACGroupOrderLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            BetaRBACGroupOrderLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaRBACGroupOrderLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
