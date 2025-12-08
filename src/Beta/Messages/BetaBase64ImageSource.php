<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBase64ImageSource\MediaType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBase64ImageSourceShape = array{
 *   data: string, media_type: value-of<MediaType>, type: 'base64'
 * }
 */
final class BetaBase64ImageSource implements BaseModel
{
    /** @use SdkModel<BetaBase64ImageSourceShape> */
    use SdkModel;

    /** @var 'base64' $type */
    #[Required]
    public string $type = 'base64';

    #[Required]
    public string $data;

    /** @var value-of<MediaType> $media_type */
    #[Required(enum: MediaType::class)]
    public string $media_type;

    /**
     * `new BetaBase64ImageSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBase64ImageSource::with(data: ..., media_type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBase64ImageSource)->withData(...)->withMediaType(...)
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
     * @param MediaType|value-of<MediaType> $media_type
     */
    public static function with(
        string $data,
        MediaType|string $media_type
    ): self {
        $obj = new self;

        $obj['data'] = $data;
        $obj['media_type'] = $media_type;

        return $obj;
    }

    public function withData(string $data): self
    {
        $obj = clone $this;
        $obj['data'] = $data;

        return $obj;
    }

    /**
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $obj = clone $this;
        $obj['media_type'] = $mediaType;

        return $obj;
    }
}
