<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The longest side of one or more images in the request exceeds the image size limit. Scale each image in `paths` so that neither side exceeds `max_side_length_pixels`, or remove it, then retry.
 *
 * @phpstan-type ImageDimensionsTooLargeErrorDetailsShape = array{
 *   errorCode: 'image_dimensions_too_large',
 *   maxSideLengthPixels: int,
 *   paths: list<string>,
 * }
 */
final class ImageDimensionsTooLargeErrorDetails implements BaseModel
{
    /** @use SdkModel<ImageDimensionsTooLargeErrorDetailsShape> */
    use SdkModel;

    /** @var 'image_dimensions_too_large' $errorCode */
    #[Required('error_code', type: new ConstantOf('image_dimensions_too_large'))]
    public string $errorCode = 'image_dimensions_too_large';

    /**
     * The limit the images exceeded: the largest width or height, in pixels, that an image on this request may have.
     */
    #[Required('max_side_length_pixels')]
    public int $maxSideLengthPixels;

    /**
     * The position of every image over the limit, in the order you sent them, nested blocks included, such as `messages.0.content.1`, or `messages.0.content.1.content.0` for an image in a `tool_result` block.
     *
     * @var list<string> $paths
     */
    #[Required(list: 'string')]
    public array $paths;

    /**
     * `new ImageDimensionsTooLargeErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImageDimensionsTooLargeErrorDetails::with(maxSideLengthPixels: ..., paths: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImageDimensionsTooLargeErrorDetails())
     *   ->withMaxSideLengthPixels(...)
     *   ->withPaths(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string> $paths
     */
    public static function with(int $maxSideLengthPixels, array $paths): self
    {
        $self = new self;

        $self['maxSideLengthPixels'] = $maxSideLengthPixels;
        $self['paths'] = $paths;

        return $self;
    }

    /**
     * @param 'image_dimensions_too_large' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The limit the images exceeded: the largest width or height, in pixels, that an image on this request may have.
     */
    public function withMaxSideLengthPixels(int $maxSideLengthPixels): self
    {
        $self = clone $this;
        $self['maxSideLengthPixels'] = $maxSideLengthPixels;

        return $self;
    }

    /**
     * The position of every image over the limit, in the order you sent them, nested blocks included, such as `messages.0.content.1`, or `messages.0.content.1.content.0` for an image in a `tool_result` block.
     *
     * @param list<string> $paths
     */
    public function withPaths(array $paths): self
    {
        $self = clone $this;
        $self['paths'] = $paths;

        return $self;
    }
}
