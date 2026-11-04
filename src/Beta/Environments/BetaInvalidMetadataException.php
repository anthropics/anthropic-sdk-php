<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * `metadata` has too many keys, a key or value that is too long, or a reserved key. The message names each problem.
 */
final class BetaInvalidMetadataException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Invalid Metadata Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'invalid_metadata'
     */
    public function getErrorCode(): string
    {
        return 'invalid_metadata';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaInvalidMetadataErrorDetails
    {
        $details = Conversion::coerce(
            BetaInvalidMetadataErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaInvalidMetadataErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
