<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Press and hold the left mouse button at the current cursor position.
 *
 * @phpstan-type BetaComputerLeftMouseDownInputShape = array<string,mixed>
 */
final class BetaComputerLeftMouseDownInput implements BaseModel
{
    /** @use SdkModel<BetaComputerLeftMouseDownInputShape> */
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
