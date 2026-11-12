<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The endpoint serves only organizations that belong to a parent organization, and this organization belongs to none.
 */
final class ParentOrganizationRequiredException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Parent Organization Required Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'parent_organization_required'
     */
    public function getErrorCode(): string
    {
        return 'parent_organization_required';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ParentOrganizationRequiredErrorDetails
    {
        $details = Conversion::coerce(
            ParentOrganizationRequiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ParentOrganizationRequiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
