<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Image content specified directly as base64 data or as a reference via a URL.
 *
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source
 * @phpstan-import-type SourceVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source
 *
 * @phpstan-type ManagedAgentsImageBlockShape = array{
 *   source: SourceShape, type: 'image'
 * }
 */
final class ManagedAgentsImageBlock implements BaseModel
{
    /** @use SdkModel<ManagedAgentsImageBlockShape> */
    use SdkModel;

    /** @var 'image' $type */
    #[Required(type: new ConstantOf('image'))]
    public string $type = 'image';

    /**
     * The source of the image data.
     *
     * @var SourceVariants $source
     */
    #[Required(union: Source::class)]
    public ManagedAgentsBase64ImageSource|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource $source;

    /**
     * `new ManagedAgentsImageBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsImageBlock::with(source: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsImageBlock())->withSource(...)
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
     */
    public static function with(
        ManagedAgentsBase64ImageSource|array|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource $source,
    ): self {
        $self = new self;

        $self['source'] = $source;

        return $self;
    }

    /**
     * The source of the image data.
     *
     * @param SourceShape $source
     */
    public function withSource(
        ManagedAgentsBase64ImageSource|array|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource $source,
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
}
