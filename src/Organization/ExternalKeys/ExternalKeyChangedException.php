<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * The external key changed while the request was validating it. Send the request again.
 */
final class ExternalKeyChangedException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic External Key Changed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_key_changed'
     */
    public function getErrorCode(): string
    {
        return 'external_key_changed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ExternalKeyChangedErrorDetails
    {
        $details = Conversion::coerce(
            ExternalKeyChangedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ExternalKeyChangedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
