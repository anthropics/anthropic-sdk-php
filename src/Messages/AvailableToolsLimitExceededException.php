<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The tools available after a message exceed a limit on their number or their size.
 */
final class AvailableToolsLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Available Tools Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'available_tools_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'available_tools_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): AvailableToolsLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            AvailableToolsLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof AvailableToolsLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
