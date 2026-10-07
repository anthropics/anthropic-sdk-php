<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Press and hold the left mouse button at the current cursor position.
 *
 * @phpstan-type ComputerLeftMouseDownInputShape = array<string,mixed>
 */
final class ComputerLeftMouseDownInput implements BaseModel
{
    /** @use SdkModel<ComputerLeftMouseDownInputShape> */
    use SdkModel;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }
}
