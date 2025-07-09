<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaToolComputerUse20250124 implements BaseModel
{
    use Model;

    #[Api('display_height_px')]
    public int $displayHeightPx;

    #[Api('display_width_px')]
    public int $displayWidthPx;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Api('display_number', optional: true)]
    public ?int $displayNumber;

    /**
     * @param int                            $displayHeightPx
     * @param int                            $displayWidthPx
     * @param string                         $name
     * @param string                         $type
     * @param null|BetaCacheControlEphemeral $cacheControl
     * @param null|int                       $displayNumber
     */
    final public function __construct(
        $displayHeightPx,
        $displayWidthPx,
        $name,
        $type,
        $cacheControl = None::NOT_GIVEN,
        $displayNumber = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaToolComputerUse20250124::_loadMetadata();
