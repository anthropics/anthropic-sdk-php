<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * On Claude Platform on AWS, the External Storage ID in the request is neither a bucket ARN nor an `estrg_` ID, or is the `estrg_` ID of AWS storage. Name AWS storage by its bucket ARN, `arn:<partition>:s3:::<bucket_name>`, which responses return as its `id`.
 */
final class InvalidStorageARNException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Invalid Storage ARN Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'invalid_storage_arn'
     */
    public function getErrorCode(): string
    {
        return 'invalid_storage_arn';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): InvalidStorageARNErrorDetails
    {
        $details = Conversion::coerce(
            InvalidStorageARNErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof InvalidStorageARNErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
