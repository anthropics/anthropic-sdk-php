<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request can't use External Storage on this cloud provider. The error's message says why.
 */
final class ProviderNotAllowedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Provider Not Allowed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'provider_not_allowed'
     */
    public function getErrorCode(): string
    {
        return 'provider_not_allowed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ProviderNotAllowedErrorDetails
    {
        $details = Conversion::coerce(
            ProviderNotAllowedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ProviderNotAllowedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
