<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Base64-encoded image data.
 *
 * @phpstan-type ManagedAgentsBase64ImageSourceShape = array{
 *   data: string, mediaType: string, type: 'base64'
 * }
 */
final class ManagedAgentsBase64ImageSource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsBase64ImageSourceShape> */
    use SdkModel;

    /** @var 'base64' $type */
    #[Required(type: new ConstantOf('base64'))]
    public string $type = 'base64';

    /**
     * Base64-encoded image data.
     */
    #[Required]
    public string $data;

    /**
     * MIME type of the image (e.g., "image/png", "image/jpeg", "image/gif", "image/webp").
     */
    #[Required('media_type')]
    public string $mediaType;

    /**
     * `new ManagedAgentsBase64ImageSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsBase64ImageSource::with(data: ..., mediaType: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsBase64ImageSource())->withData(...)->withMediaType(...)
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
     */
    public static function with(string $data, string $mediaType): self
    {
        $self = new self;

        $self['data'] = $data;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * Base64-encoded image data.
     */
    public function withData(string $data): self
    {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * MIME type of the image (e.g., "image/png", "image/jpeg", "image/gif", "image/webp").
     */
    public function withMediaType(string $mediaType): self
    {
        $self = clone $this;
        $self['mediaType'] = $mediaType;

        return $self;
    }

    /**
     * @param 'base64' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
