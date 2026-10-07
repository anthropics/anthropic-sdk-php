<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Release the left mouse button.
 *
 * @phpstan-type ComputerLeftMouseUpInputShape = array<string,mixed>
 */
final class ComputerLeftMouseUpInput implements BaseModel
{
    /** @use SdkModel<ComputerLeftMouseUpInputShape> */
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
