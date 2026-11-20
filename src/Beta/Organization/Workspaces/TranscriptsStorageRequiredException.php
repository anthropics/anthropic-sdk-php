<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * In an organization managed through AWS or Google Cloud, the request would leave the Workspace with `inference_data_privacy.human_review` disabled and `inference_data_privacy.transcripts_storage` not set to External Storage. With human review disabled, the organization reviews its own flagged requests, and it receives them only in that storage.
 */
final class TranscriptsStorageRequiredException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Transcripts Storage Required Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'transcripts_storage_required'
     */
    public function getErrorCode(): string
    {
        return 'transcripts_storage_required';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): TranscriptsStorageRequiredErrorDetails
    {
        $details = Conversion::coerce(
            TranscriptsStorageRequiredErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof TranscriptsStorageRequiredErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
