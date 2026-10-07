<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get the current (x, y) pixel coordinate of the cursor.
 *
 * @phpstan-type BetaComputerCursorPositionInputShape = array<string,mixed>
 */
final class BetaComputerCursorPositionInput implements BaseModel
{
    /** @use SdkModel<BetaComputerCursorPositionInputShape> */
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
