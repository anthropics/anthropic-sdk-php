<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ServiceUnavailableException;
use Anthropic\Core\Util;

/**
 * The workspace's customer-managed encryption key could not be reached. Retry the request; if this continues, check that the key is available in your key management service, or contact Anthropic support.
 */
final class CMEKKeyUnreachableException extends ServiceUnavailableException
{
    /** @var string */
    protected const DESC = 'Anthropic CMEK Key Unreachable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cmek_key_unreachable'
     */
    public function getErrorCode(): string
    {
        return 'cmek_key_unreachable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CMEKKeyUnreachableErrorDetails
    {
        $details = Conversion::coerce(
            CMEKKeyUnreachableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CMEKKeyUnreachableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
