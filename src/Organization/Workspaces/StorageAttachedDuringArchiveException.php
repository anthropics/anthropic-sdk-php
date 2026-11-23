<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\ConflictException;
use Anthropic\Core\Util;

/**
 * The Workspace was archived, but External Storage was attached to it during the archive and is still attached. To detach it, archive the Workspace again as a caller with the `org:external-storage:use` permission.
 */
final class StorageAttachedDuringArchiveException extends ConflictException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Attached During Archive Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_attached_during_archive'
     */
    public function getErrorCode(): string
    {
        return 'storage_attached_during_archive';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageAttachedDuringArchiveErrorDetails
    {
        $details = Conversion::coerce(
            StorageAttachedDuringArchiveErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageAttachedDuringArchiveErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
