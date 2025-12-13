<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaBase64ImageSource\MediaType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaBase64ImageSourceShape = array{
 *   data: string, mediaType: value-of<MediaType>, type?: 'base64'
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

    /** @var value-of<MediaType> $mediaType */
    #[Required('media_type', enum: MediaType::class)]
    public string $mediaType;

    /**
     * `new BetaBase64ImageSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBase64ImageSource::with(data: ..., mediaType: ...)
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
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public static function with(string $data, MediaType|string $mediaType): self
    {
        $self = new self;

        $self['data'] = $data;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    public function withData(string $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * @param MediaType|value-of<MediaType> $mediaType
     */
    public function withMediaType(MediaType|string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }
}
