<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextDeltaShape = array{text: string, type?: 'text_delta'}
 */
final class TextDelta implements BaseModel
{
    /** @use SdkModel<TextDeltaShape> */
    use SdkModel;

    /** @var 'text_delta' $type */
    #[Required]
    public string $type = 'text_delta';

    #[Required]
    public string $text;

    /**
     * `new TextDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextDelta::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextDelta)->withText(...)
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

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
