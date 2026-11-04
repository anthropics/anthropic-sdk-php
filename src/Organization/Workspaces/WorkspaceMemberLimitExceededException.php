<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The workspace has reached the member limit that Anthropic set for it.
 */
final class WorkspaceMemberLimitExceededException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Workspace Member Limit Exceeded Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'workspace_member_limit_exceeded'
     */
    public function getErrorCode(): string
    {
        return 'workspace_member_limit_exceeded';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): WorkspaceMemberLimitExceededErrorDetails
    {
        $details = Conversion::coerce(
            WorkspaceMemberLimitExceededErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof WorkspaceMemberLimitExceededErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
