<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The request would leave the Workspace with `inference_data_privacy.safeguards_storage` set to External Storage and `inference_data_privacy.human_review` enabled. Anthropic doesn't offer human review of data in a customer's own storage. Set `human_review` to `disabled`, or `safeguards_storage` to `internal`.
 */
final class HumanReviewOnWithExternalStorageException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Human Review On With External Storage Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'human_review_on_with_external_storage'
     */
    public function getErrorCode(): string
    {
        return 'human_review_on_with_external_storage';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): HumanReviewOnWithExternalStorageErrorDetails
    {
        $details = Conversion::coerce(
            HumanReviewOnWithExternalStorageErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof HumanReviewOnWithExternalStorageErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
