<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * This Bundle's instructions are managed in claude.ai and can't be changed through the API.
 */
final class BundleOnCallException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Bundle On Call Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'bundle_on_call'
     */
    public function getErrorCode(): string
    {
        return 'bundle_on_call';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BundleOnCallErrorDetails
    {
        $details = Conversion::coerce(
            BundleOnCallErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BundleOnCallErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
