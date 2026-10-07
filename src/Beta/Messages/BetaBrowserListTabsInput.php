<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List all open tabs with each tab's tab_id, title, and URL.
 *
 * @phpstan-type BetaBrowserListTabsInputShape = array<string,mixed>
 */
final class BetaBrowserListTabsInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserListTabsInputShape> */
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
