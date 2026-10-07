<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get the current (x, y) pixel coordinate of the cursor.
 *
 * @phpstan-type ComputerCursorPositionInputShape = array<string,mixed>
 */
final class ComputerCursorPositionInput implements BaseModel
{
    /** @use SdkModel<ComputerCursorPositionInputShape> */
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
