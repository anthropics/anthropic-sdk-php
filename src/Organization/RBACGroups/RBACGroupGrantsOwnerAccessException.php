<?php

declare(strict_types=1);

namespace Anthropic\Organization\RBACGroups;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * A role attached to an RBAC Group in the request grants owner access, so this API does not add members to that group (directly or through an invite), remove its members, or delete it. Make the change in the organization's admin settings in Claude.
 */
final class RBACGroupGrantsOwnerAccessException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic RBAC Group Grants Owner Access Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'rbac_group_grants_owner_access'
     */
    public function getErrorCode(): string
    {
        return 'rbac_group_grants_owner_access';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RBACGroupGrantsOwnerAccessErrorDetails
    {
        $details = Conversion::coerce(
            RBACGroupGrantsOwnerAccessErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RBACGroupGrantsOwnerAccessErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
