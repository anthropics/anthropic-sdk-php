<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\NotFoundException;
use Anthropic\Core\Util;

/**
 * The RBAC Group is not one of the organization's groups.
 */
final class RBACGroupNotFoundException extends NotFoundException
{
    /** @var string */
    protected const DESC = 'Anthropic RBAC Group Not Found Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'rbac_group_not_found'
     */
    public function getErrorCode(): string
    {
        return 'rbac_group_not_found';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): RBACGroupNotFoundErrorDetails
    {
        $details = Conversion::coerce(
            RBACGroupNotFoundErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof RBACGroupNotFoundErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
