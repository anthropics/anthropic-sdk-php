<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source;
use Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Image content specified directly as base64 data or as a reference via a URL.
 *
 * @phpstan-import-type SourceVariants from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source
 *
 * @phpstan-type ManagedAgentsImageBlockShape = array{
 *   source: SourceShape, type: Type|value-of<Type>
 * }
 */
final class ManagedAgentsImageBlock implements BaseModel
{
    /** @use SdkModel<ManagedAgentsImageBlockShape> */
    use SdkModel;

    /**
     * Union type for image source variants.
     *
     * @var SourceVariants $source
     */
    #[Required(union: Source::class)]
    public ManagedAgentsBase64ImageSource|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource $source;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new ManagedAgentsImageBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsImageBlock::with(source: ..., type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsImageBlock)->withSource(...)->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(
        ManagedAgentsBase64ImageSource|array|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource $source,
        Type|string $type,
    ): self {
        $self = new self;

        $self['source'] = $source;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Union type for image source variants.
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
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
