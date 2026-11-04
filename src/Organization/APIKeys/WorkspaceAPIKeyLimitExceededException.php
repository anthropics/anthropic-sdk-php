<?php

declare(strict_types=1);

namespace Anthropic\Organization\APIKeys;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The workspace has reached its limit of active API keys.
 */
final class WorkspaceAPIKeyLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Workspace API Key Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'workspace_api_key_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'workspace_api_key_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): WorkspaceAPIKeyLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            WorkspaceAPIKeyLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof WorkspaceAPIKeyLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
