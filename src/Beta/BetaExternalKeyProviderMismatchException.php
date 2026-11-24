<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The External Key is held by a key management service that this endpoint does not take. The message names the field and the service it takes.
 */
final class BetaExternalKeyProviderMismatchException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta External Key Provider Mismatch Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_key_provider_mismatch'
     */
    public function getErrorCode(): string
    {
        return 'external_key_provider_mismatch';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaExternalKeyProviderMismatchErrorDetails
    {
        $details = Conversion::coerce(
            BetaExternalKeyProviderMismatchErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaExternalKeyProviderMismatchErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
