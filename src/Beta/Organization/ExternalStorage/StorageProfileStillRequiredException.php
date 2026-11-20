<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * This storage is bound to a different user profile from storage the Workspace has attached, or from active or draining storage it once had for safeguards data. Detaching storage the Workspace uses only for transcripts clears this. Detaching safeguards storage doesn't, so use a new Workspace instead.
 */
final class StorageProfileStillRequiredException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Storage Profile Still Required Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'storage_profile_still_required'
     */
    public function getErrorCode(): string
    {
        return 'storage_profile_still_required';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): StorageProfileStillRequiredErrorDetails
    {
        $details = Conversion::coerce(
            StorageProfileStillRequiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof StorageProfileStillRequiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
