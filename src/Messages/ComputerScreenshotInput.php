<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Take a screenshot of the screen.
 *
 * @phpstan-type ComputerScreenshotInputShape = array<string,mixed>
 */
final class ComputerScreenshotInput implements BaseModel
{
    /** @use SdkModel<ComputerScreenshotInputShape> */
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
