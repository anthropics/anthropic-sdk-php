<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;

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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param int                       $displayHeightPx `required`
     * @param int                       $displayWidthPx  `required`
     * @param string                    $name            `required`
     * @param string                    $type            `required`
     * @param BetaCacheControlEphemeral $cacheControl
     * @param null|int                  $displayNumber
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

BetaToolComputerUse20241022::_loadMetadata();
