<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Type a string of text on the keyboard.
 *
 * @phpstan-type ComputerTypeInputShape = array{text: string}
 */
final class ComputerTypeInput implements BaseModel
{
    /** @use SdkModel<ComputerTypeInputShape> */
    use SdkModel;

    /**
     * The text to type.
     */
    #[Required]
    public string $text;

    /**
     * `new ComputerTypeInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ComputerTypeInput::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ComputerTypeInput())->withText(...)
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
     * The text to type.
     */
    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
