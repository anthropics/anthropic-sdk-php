<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Close the tab with the given tab_id.
 *
 * @phpstan-type BetaBrowserCloseTabInputShape = array{tabID: string}
 */
final class BetaBrowserCloseTabInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserCloseTabInputShape> */
    use SdkModel;

    /**
     * The tab to close.
     */
    #[Required('tab_id')]
    public string $tabID;

    /**
     * `new BetaBrowserCloseTabInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserCloseTabInput::with(tabID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserCloseTabInput())->withTabID(...)
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
    public static function with(string $tabID): self
    {
        $self = new self;

        $self['tabID'] = $tabID;

        return $self;
    }

    /**
     * The tab to close.
     */
    public function withTabID(string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }
}
