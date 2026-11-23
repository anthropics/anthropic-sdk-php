<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The External Storage can't be deleted while an Enterprise Frontier Safeguards workspace policy lists it as allowed storage.
 */
final class ExternalStorageInWorkspacePolicyException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic External Storage In Workspace Policy Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'external_storage_in_workspace_policy'
     */
    public function getErrorCode(): string
    {
        return 'external_storage_in_workspace_policy';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ExternalStorageInWorkspacePolicyErrorDetails
    {
        $details = Conversion::coerce(
            ExternalStorageInWorkspacePolicyErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ExternalStorageInWorkspacePolicyErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
