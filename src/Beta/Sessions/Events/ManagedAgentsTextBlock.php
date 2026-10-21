<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Regular text content.
 *
 * @phpstan-type ManagedAgentsTextBlockShape = array{text: string, type: 'text'}
 */
final class ManagedAgentsTextBlock implements BaseModel
{
    /** @use SdkModel<ManagedAgentsTextBlockShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required(type: new ConstantOf('text'))]
    public string $type = 'text';

    /**
     * The text content.
     */
    #[Required]
    public string $text;

    /**
     * `new ManagedAgentsTextBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ManagedAgentsTextBlock::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ManagedAgentsTextBlock())->withText(...)
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
    public static function with(string $text): self
    {
        $self = new self;

        $self['text'] = $text;

        return $self;
    }

    /**
     * The text content.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }

    /**
     * @param 'text' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
