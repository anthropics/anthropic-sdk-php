<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
 */
final class OrganizationOnHoldException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Organization On Hold Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'organization_on_hold'
     */
    public function getErrorCode(): string
    {
        return 'organization_on_hold';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): OrganizationOnHoldErrorDetails
    {
        $details = Conversion::coerce(
            OrganizationOnHoldErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof OrganizationOnHoldErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
