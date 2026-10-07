<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Open a new empty tab and return its tab_id.
 *
 * @phpstan-type BetaBrowserNewTabInputShape = array<string,mixed>
 */
final class BetaBrowserNewTabInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserNewTabInputShape> */
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
