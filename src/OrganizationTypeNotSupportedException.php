<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The endpoint does not support the organization's type. Each endpoint's description says which organization types it supports.
 */
final class OrganizationTypeNotSupportedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Organization Type Not Supported Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'organization_type_not_supported'
     */
    public function getErrorCode(): string
    {
        return 'organization_type_not_supported';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): OrganizationTypeNotSupportedErrorDetails
    {
        $details = Conversion::coerce(
            OrganizationTypeNotSupportedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof OrganizationTypeNotSupportedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
