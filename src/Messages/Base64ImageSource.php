<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Base64ImageSource\MediaType;

/**
 * @phpstan-type base64_image_source_alias = array{
 *   data: string, mediaType: MediaType::*, type: string
 * }
 */
final class Base64ImageSource implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'base64';

    #[Api]
    public string $data;

    /** @var MediaType::* $mediaType */
    #[Api('media_type', enum: MediaType::class)]
    public string $mediaType;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MediaType::* $mediaType
     */
    public static function from(string $data, string $mediaType): self
    {
        $obj = new self;

        $obj->data = $data;
        $obj->mediaType = $mediaType;

        return $obj;
    }

    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param MediaType::* $mediaType
     */
    public function setMediaType(string $mediaType): self
    {
        $this->mediaType = $mediaType;

        return $this;
    }
}
