<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaToolComputerUse20250124Shape = array{
 *   display_height_px: int,
 *   display_width_px: int,
 *   name: "computer",
 *   type: "computer_20250124",
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   display_number?: int|null,
 *   strict?: bool|null,
 * }
 */
final class BetaToolComputerUse20250124 implements BaseModel
{
    /** @use SdkModel<BetaToolComputerUse20250124Shape> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     *
     * @var "computer" $name
     */
    #[Api]
    public string $name = 'computer';

    /** @var "computer_20250124" $type */
    #[Api]
    public string $type = 'computer_20250124';

    /**
     * The height of the display in pixels.
     */
    #[Api]
    public int $display_height_px;

    /**
     * The width of the display in pixels.
     */
    #[Api]
    public int $display_width_px;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    #[Api(nullable: true, optional: true)]
    public ?int $display_number;

    #[Api(optional: true)]
    public ?bool $strict;

    /**
     * `new BetaToolComputerUse20250124()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolComputerUse20250124::with(display_height_px: ..., display_width_px: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolComputerUse20250124)
     *   ->withDisplayHeightPx(...)
     *   ->withDisplayWidthPx(...)
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
    public static function with(
        int $display_height_px,
        int $display_width_px,
        ?BetaCacheControlEphemeral $cache_control = null,
        ?int $display_number = null,
        ?bool $strict = null,
    ): self {
        $obj = new self;

        $obj->display_height_px = $display_height_px;
        $obj->display_width_px = $display_width_px;

        null !== $cache_control && $obj->cache_control = $cache_control;
        null !== $display_number && $obj->display_number = $display_number;
        null !== $strict && $obj->strict = $strict;

        return $obj;
    }

    /**
     * The height of the display in pixels.
     */
    public function withDisplayHeightPx(int $displayHeightPx): self
    {
        $obj = clone $this;
        $obj->display_height_px = $displayHeightPx;

        return $obj;
    }

    /**
     * The width of the display in pixels.
     */
    public function withDisplayWidthPx(int $displayWidthPx): self
    {
        $obj = clone $this;
        $obj->display_width_px = $displayWidthPx;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        ?BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

        return $obj;
    }

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    public function withDisplayNumber(?int $displayNumber): self
    {
        $obj = clone $this;
        $obj->display_number = $displayNumber;

        return $obj;
    }

    public function withStrict(bool $strict): self
    {
        $obj = clone $this;
        $obj->strict = $strict;

        return $obj;
    }
}
