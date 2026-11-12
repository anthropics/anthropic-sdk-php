<?php

declare(strict_types=1);

namespace Anthropic\Organization;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Util;

/**
 * No RBAC Role with this ID was found.
 */
final class RBACRoleNotFoundException extends NotFoundException
{
    /** @var string */
    protected const DESC = 'Anthropic RBAC Role Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'rbac_role_not_found'
     */
    public function getErrorCode(): string
    {
        return 'rbac_role_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RBACRoleNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            RBACRoleNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RBACRoleNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
