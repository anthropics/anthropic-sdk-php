<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The environment is archived, so it cannot be updated.
 */
final class BetaEnvironmentArchivedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta Environment Archived Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'environment_archived'
     */
    public function getErrorCode(): string
    {
        return 'environment_archived';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaEnvironmentArchivedErrorDetails
    {
        $details = Conversion::coerce(
            BetaEnvironmentArchivedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaEnvironmentArchivedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
