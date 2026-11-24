<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization has no active External Key with this ID. The message names the field.
 */
final class BetaExternalKeyNotFoundException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta External Key Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_key_not_found'
     */
    public function getErrorCode(): string
    {
        return 'external_key_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaExternalKeyNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            BetaExternalKeyNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaExternalKeyNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
