<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
 */
final class CMEKKeyNetworkBlockedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic CMEK Key Network Blocked Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cmek_key_network_blocked'
     */
    public function getErrorCode(): string
    {
        return 'cmek_key_network_blocked';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CMEKKeyNetworkBlockedErrorDetails
    {
        $details = Conversion::coerce(
            CMEKKeyNetworkBlockedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CMEKKeyNetworkBlockedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
