<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ServiceUnavailableException;
use Anthropic\Core\Util;

/**
 * The workspace's encryption settings could not be read, so the request was refused. Retry in a few minutes.
 */
final class CMEKContextUnavailableException extends ServiceUnavailableException
{
    /** @var string */
    protected const DESC = 'Anthropic CMEK Context Unavailable Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cmek_context_unavailable'
     */
    public function getErrorCode(): string
    {
        return 'cmek_context_unavailable';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): CMEKContextUnavailableErrorDetails
    {
        $details = Conversion::coerce(
            CMEKContextUnavailableErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof CMEKContextUnavailableErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
