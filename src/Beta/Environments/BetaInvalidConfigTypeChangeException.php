<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * `config.type` differs from the environment's stored type, which cannot change after creation.
 */
final class BetaInvalidConfigTypeChangeException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Invalid Config Type Change Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'invalid_config_type_change'
     */
    public function getErrorCode(): string
    {
        return 'invalid_config_type_change';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaInvalidConfigTypeChangeErrorDetails
    {
        $details = Conversion::coerce(
            BetaInvalidConfigTypeChangeErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaInvalidConfigTypeChangeErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
