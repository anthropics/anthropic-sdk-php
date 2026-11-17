<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\RateLimitException;
use Anthropic\Core\Util;

/**
 * The organization has reached the spend limit of its contract.
 */
final class ContractSpendLimitReachedException extends RateLimitException
{
    /** @var string */
    protected const DESC = 'Anthropic Contract Spend Limit Reached Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'contract_spend_limit_reached'
     */
    public function getErrorCode(): string
    {
        return 'contract_spend_limit_reached';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ContractSpendLimitReachedErrorDetails
    {
        $details = Conversion::coerce(
            ContractSpendLimitReachedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ContractSpendLimitReachedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
