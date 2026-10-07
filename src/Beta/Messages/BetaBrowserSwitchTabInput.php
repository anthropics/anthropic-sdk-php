<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Make the tab with the given tab_id the active tab — the tab that actions without
 * a tab_id apply to.
 *
 * @phpstan-type BetaBrowserSwitchTabInputShape = array{tabID: string}
 */
final class BetaBrowserSwitchTabInput implements BaseModel
{
    /** @use SdkModel<BetaBrowserSwitchTabInputShape> */
    use SdkModel;

    /**
     * The tab to switch to.
     */
    #[Required('tab_id')]
    public string $tabID;

    /**
     * `new BetaBrowserSwitchTabInput()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaBrowserSwitchTabInput::with(tabID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaBrowserSwitchTabInput())->withTabID(...)
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
     * The tab to switch to.
     */
    public function withTabID(string $tabID): self
    {
        $self = clone $this;
        $self['tabID'] = $tabID;

        return $self;
    }
}
