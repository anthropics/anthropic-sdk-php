<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

class BetaToolComputerUse20241022 implements BaseModel
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
    public BetaCacheControlEphemeral $cacheControl;

    #[Api('display_number', optional: true)]
    public ?int $displayNumber;

    /**
     * @param BetaCacheControlEphemeral $cacheControl
     * @param null|int                  $displayNumber
     */
    final public function __construct(
        int $displayHeightPx,
        int $displayWidthPx,
        string $name,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
        null|int|None $displayNumber = None::NOT_SET
    ) {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

BetaToolComputerUse20241022::_loadMetadata();
