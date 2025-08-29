<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Base64ImageSource\MediaType;

/**
 * @phpstan-type base64_image_source = array{
 *   data: string, mediaType: MediaType::*, type: string
 * }
 */
final class Base64ImageSource implements BaseModel
{
    /** @use SdkModel<base64_image_source> */
    use SdkModel;

    #[Api]
    public string $type = 'base64';

    #[Api]
    public string $data;

    /** @var MediaType::* $mediaType */
    #[Api('media_type', enum: MediaType::class)]
    public string $mediaType;

    /**
     * `new Base64ImageSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Base64ImageSource::with(data: ..., mediaType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Base64ImageSource)->withData(...)->withMediaType(...)
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
     * @param MediaType::* $mediaType
     */
    public static function with(string $data, string $mediaType): self
    {
        $obj = new self;

        $obj->data = $data;
        $obj->mediaType = $mediaType;

        return $obj;
    }

    public function withData(string $data): self
    {
        $obj = clone $this;
        $obj->data = $data;

        return $obj;
    }

    /**
     * @param MediaType::* $mediaType
     */
    public function withMediaType(string $mediaType): self
    {
        $obj = clone $this;
        $obj->mediaType = $mediaType;

        return $obj;
    }
}
