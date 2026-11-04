<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\Work;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\PreconditionFailedException;
use Anthropic\Core\Util;

/**
 * `expected_last_heartbeat` does not match the stored heartbeat, so another worker may hold the lease.
 */
final class HeartbeatPreconditionFailedException extends PreconditionFailedException
{
    /** @var string */
    protected const DESC = 'Anthropic Heartbeat Precondition Failed Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'heartbeat_precondition_failed'
     */
    public function getErrorCode(): string
    {
        return 'heartbeat_precondition_failed';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): HeartbeatPreconditionFailedErrorDetails
    {
        $details = Conversion::coerce(
            HeartbeatPreconditionFailedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof HeartbeatPreconditionFailedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
