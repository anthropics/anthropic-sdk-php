<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaToolComputerUse20241022 implements BaseModel
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
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        int $displayHeightPx,
        int $displayWidthPx,
        string $name,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?int $displayNumber = null,
    ) {
        $this->displayHeightPx = $displayHeightPx;
        $this->displayWidthPx = $displayWidthPx;
        $this->name = $name;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
        $this->displayNumber = $displayNumber;
    }
}

BetaToolComputerUse20241022::_loadMetadata();
