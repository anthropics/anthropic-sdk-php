<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Open a new empty tab and return its tab_id.
 *
 * @phpstan-type BrowserNewTabInputShape = array<string,mixed>
 */
final class BrowserNewTabInput implements BaseModel
{
    /** @use SdkModel<BrowserNewTabInputShape> */
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
