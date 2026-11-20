<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Conversion;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Exceptions\BadRequestException;
use Anthropic\Core\Util;

/**
 * The longest side of one or more images in the request exceeds the image size limit. Scale each image in `paths` so that neither side exceeds `max_side_length_pixels`, or remove it, then retry.
 */
final class ImageDimensionsTooLargeException extends BadRequestException
{
    /** @var string */
    protected const DESC = 'Anthropic Image Dimensions Too Large Exception';

    /**
     * `error.details.error_code` from the response body.
     *
     * @return 'image_dimensions_too_large'
     */
    public function getErrorCode(): string
    {
        return 'image_dimensions_too_large';
    }

    /**
     * `error.details` from the response body.
     *
     * @throws AnthropicException
     */
    public function getDetails(): ImageDimensionsTooLargeErrorDetails
    {
        $details = Conversion::coerce(
            ImageDimensionsTooLargeErrorDetails::class,
            value: Util::dig(Util::dig($this->body, 'error'), 'details'),
        );

        if (!$details instanceof ImageDimensionsTooLargeErrorDetails) {
            throw new AnthropicException('The response body has no `error.details` object.');
        }

        return $details;
    }
}
