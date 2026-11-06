<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PermissionDeniedException;
use Anthropic\Core\Util;

/**
 * The request came from a Claude sandbox with restricted network access, which is not allowed to make this change. Send it from outside the sandbox, or from a sandbox with unrestricted network access.
 */
final class SandboxEgressRestrictedException extends PermissionDeniedException
{
    /** @var string */
    protected const DESC = 'Anthropic Sandbox Egress Restricted Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'sandbox_egress_restricted'
     */
    public function getErrorCode(): string
    {
        return 'sandbox_egress_restricted';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): SandboxEgressRestrictedErrorDetails
    {
        $details = Conversion::coerce(
            SandboxEgressRestrictedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof SandboxEgressRestrictedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
