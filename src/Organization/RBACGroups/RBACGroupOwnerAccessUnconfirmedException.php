<?php

declare(strict_types=1);

namespace Anthropic\Organization\RBACGroups;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The API could not finish checking whether an RBAC Group in the request grants owner access, so it made no change. Retrying the same request will not help. Make the change in the organization's admin settings in Claude.
 */
final class RBACGroupOwnerAccessUnconfirmedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic RBAC Group Owner Access Unconfirmed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'rbac_group_owner_access_unconfirmed'
     */
    public function getErrorCode(): string
    {
        return 'rbac_group_owner_access_unconfirmed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RBACGroupOwnerAccessUnconfirmedErrorDetails
    {
        $details = Conversion::coerce(
            RBACGroupOwnerAccessUnconfirmedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RBACGroupOwnerAccessUnconfirmedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
