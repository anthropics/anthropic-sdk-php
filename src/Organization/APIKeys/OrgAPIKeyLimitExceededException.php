<?php

declare(strict_types=1);

namespace Anthropic\Organization\APIKeys;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The organization has reached its limit of active API keys.
 */
final class OrgAPIKeyLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Org API Key Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'org_api_key_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'org_api_key_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): OrgAPIKeyLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            OrgAPIKeyLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof OrgAPIKeyLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
