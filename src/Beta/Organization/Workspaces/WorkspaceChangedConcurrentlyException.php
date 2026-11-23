<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * Another request changed the Workspace, so this request left the setting named in `field` as it is. The error's `message` says which of this request's other changes are in place. Read the Workspace and send the request again if you still want the change.
 */
final class WorkspaceChangedConcurrentlyException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Workspace Changed Concurrently Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'workspace_changed_concurrently'
     */
    public function getErrorCode(): string
    {
        return 'workspace_changed_concurrently';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): WorkspaceChangedConcurrentlyErrorDetails
    {
        $details = Conversion::coerce(
            WorkspaceChangedConcurrentlyErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof WorkspaceChangedConcurrentlyErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
