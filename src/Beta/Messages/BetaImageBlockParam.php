<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaImageBlockParam\Source;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type SourceVariants from \Anthropic\Beta\Messages\BetaImageBlockParam\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Messages\BetaImageBlockParam\Source
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaImageTransformationsParamShape from \Anthropic\Beta\Messages\BetaImageTransformationsParam
 *
 * @phpstan-type BetaImageBlockParamShape = array{
 *   source: SourceShape,
 *   type: 'image',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   transformations?: null|BetaImageTransformationsParam|BetaImageTransformationsParamShape,
 * }
 */
final class BetaImageBlockParam implements BaseModel
{
    /** @use SdkModel<BetaImageBlockParamShape> */
    use SdkModel;

    /** @var 'image' $type */
    #[Required]
    public string $type = 'image';

    /** @var SourceVariants $source */
    #[Required(union: Source::class)]
    public BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource $source;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * Configures the transformations the server applies to this image before the model observes it. Each key names a condition the server transforms images for; its value selects the transformation applied. Omitted keys keep their default behavior, and an empty object is equivalent to omitting the field.
     */
    #[Optional(nullable: true)]
    public ?BetaImageTransformationsParam $transformations;

    /**
     * `new BetaImageBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaImageBlockParam::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaImageBlockParam)->withSource(...)
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param BetaImageTransformationsParam|BetaImageTransformationsParamShape|null $transformations
     */
    public static function with(
        BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource $source,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        BetaImageTransformationsParam|array|null $transformations = null,
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
        BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource $source
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
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * Configures the transformations the server applies to this image before the model observes it. Each key names a condition the server transforms images for; its value selects the transformation applied. Omitted keys keep their default behavior, and an empty object is equivalent to omitting the field.
     *
     * @param BetaImageTransformationsParam|BetaImageTransformationsParamShape|null $transformations
     */
    public function withTransformations(
        BetaImageTransformationsParam|array|null $transformations
    ): self {
        $self = clone $this;
        $self['transformations'] = $transformations;

        return $self;
    }
}
