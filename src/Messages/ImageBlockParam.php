<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\ImageBlockParam\Source;

/**
 * @phpstan-import-type SourceShape from \Anthropic\Messages\ImageBlockParam\Source
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 *
 * @phpstan-type ImageBlockParamShape = array{
 *   source: Base64ImageSource|URLImageSource|SourceShape,
 *   type: 'image',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 * }
 */
final class ImageBlockParam implements BaseModel
{
    /** @use SdkModel<ImageBlockParamShape> */
    use SdkModel;

    /** @var 'image' $type */
    #[Required]
    public string $type = 'image';

    #[Required(union: Source::class)]
    public Base64ImageSource|URLImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

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
     * @param CacheControlEphemeralShape|null $cacheControl
     */
    public static function with(
        Base64ImageSource|array|URLImageSource $source,
        CacheControlEphemeral|array|null $cacheControl = null,
    ): self {
        $self = new self;

        $self['source'] = $source;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param SourceShape $source
     */
    public function withSource(
        Base64ImageSource|array|URLImageSource $source
    ): self {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }
}
