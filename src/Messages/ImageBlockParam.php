<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ImageBlockParam\Source;

/**
 * @phpstan-import-type SourceVariants from \Anthropic\Messages\ImageBlockParam\Source
 * @phpstan-import-type SourceShape from \Anthropic\Messages\ImageBlockParam\Source
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type ImageTransformationsParamShape from \Anthropic\Messages\ImageTransformationsParam
 *
 * @phpstan-type ImageBlockParamShape = array{
 *   source: SourceShape,
 *   type: 'image',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   transformations?: null|ImageTransformationsParam|ImageTransformationsParamShape,
 * }
 */
final class ImageBlockParam implements BaseModel
{
    /** @use SdkModel<ImageBlockParamShape> */
    use SdkModel;

    /** @var 'image' $type */
    #[Required]
    public string $type = 'image';

    /** @var SourceVariants $source */
    #[Required(union: Source::class)]
    public Base64ImageSource|URLImageSource|FileImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * Configures the transformations the server applies to this image before the model observes it. Each key names a condition the server transforms images for; its value selects the transformation applied. Omitted keys keep their default behavior, and an empty object is equivalent to omitting the field.
     */
    #[Optional(nullable: true)]
    public ?ImageTransformationsParam $transformations;

    /**
     * `new ImageBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ImageBlockParam::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ImageBlockParam)->withSource(...)
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
     * @param SourceShape $source
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param ImageTransformationsParam|ImageTransformationsParamShape|null $transformations
     */
    public static function with(
        Base64ImageSource|array|URLImageSource|FileImageSource $source,
        CacheControlEphemeral|array|null $cacheControl = null,
        ImageTransformationsParam|array|null $transformations = null,
    ): self {
        $self = new self;

        $self['source'] = $source;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $transformations && $self['transformations'] = $transformations;

        return $self;
    }

    /**
     * @param SourceShape $source
     */
    public function withSource(
        Base64ImageSource|array|URLImageSource|FileImageSource $source
    ): self {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * @param 'image' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Configures the transformations the server applies to this image before the model observes it. Each key names a condition the server transforms images for; its value selects the transformation applied. Omitted keys keep their default behavior, and an empty object is equivalent to omitting the field.
     *
     * @param ImageTransformationsParam|ImageTransformationsParamShape|null $transformations
     */
    public function withTransformations(
        ImageTransformationsParam|array|null $transformations
    ): self {
        $self = clone $this;
        $self['transformations'] = $transformations;

        return $self;
    }
}
