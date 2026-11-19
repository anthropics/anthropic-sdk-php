<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * This stored settings document currently cannot be read or replaced. Contact support, or, if you no longer need these settings, delete the group's settings or clear the default.
 */
final class BetaCMEKFeatureUnsupportedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Beta CMEK Feature Unsupported Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'cmek_feature_unsupported'
     */
    public function getErrorCode(): string
    {
        return 'cmek_feature_unsupported';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BetaCMEKFeatureUnsupportedErrorDetails
    {
        $details = Conversion::coerce(
            BetaCMEKFeatureUnsupportedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BetaCMEKFeatureUnsupportedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
