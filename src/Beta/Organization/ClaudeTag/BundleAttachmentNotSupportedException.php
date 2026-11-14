<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The Bundle has an attachment this API does not support editing, so its instructions can be changed only in claude.ai.
 */
final class BundleAttachmentNotSupportedException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Bundle Attachment Not Supported Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'bundle_attachment_not_supported'
     */
    public function getErrorCode(): string
    {
        return 'bundle_attachment_not_supported';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): BundleAttachmentNotSupportedErrorDetails
    {
        $details = Conversion::coerce(
            BundleAttachmentNotSupportedErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof BundleAttachmentNotSupportedErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
