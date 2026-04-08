<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\Events\ManagedAgentsURLImageSource\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Image referenced by URL.
 *
 * @phpstan-type ManagedAgentsURLImageSourceShape = array{
 *   type: Type|value-of<Type>, url: string
 * }
 */
final class ManagedAgentsURLImageSource implements BaseModel
{
    /** @use SdkModel<ManagedAgentsURLImageSourceShape> */
    use SdkModel;

    /** @var value-of<Type> $type */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * URL of the image to fetch.
     */
    #[Required]
    public string $url;

    /**
     * `new ManagedAgentsURLImageSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsURLImageSource::with(type: ..., url: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsURLImageSource)->withType(...)->withURL(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(Type|string $type, string $url): self
    {
        $self = new self;

        $self['type'] = $type;
        $self['url'] = $url;

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

    /**
     * URL of the image to fetch.
     */
    public function withURL(string $url): self
    {
        $self = clone $this;
        $self['url'] = $url;

        return $self;
    }
}
