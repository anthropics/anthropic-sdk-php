<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ServiceUnavailableException;
use Anthropic\Core\Util;

/**
 * The Workspace was created, but some of what the request asked for did not take effect, or may not have. Don't send the create again. The error's `message` says what to do with the Workspace at `workspace_id`.
 */
final class WorkspaceCreatedIncompleteException extends ServiceUnavailableException
{
    /** @var string */
    protected const DESC = 'Anthropic Workspace Created Incomplete Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'workspace_created_incomplete'
     */
    public function getErrorCode(): string
    {
        return 'workspace_created_incomplete';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): WorkspaceCreatedIncompleteErrorDetails
    {
        $details = Conversion::coerce(
            WorkspaceCreatedIncompleteErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof WorkspaceCreatedIncompleteErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
