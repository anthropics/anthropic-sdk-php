<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_tool_computer_use20241022 = array{
 *   displayHeightPx: int,
 *   displayWidthPx: int,
 *   name: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   displayNumber?: int|null,
 * }
 */
final class BetaToolComputerUse20241022 implements BaseModel
{
    /** @use SdkModel<beta_tool_computer_use20241022> */
    use SdkModel;

    /**
     * Name of the tool.
     *
     * This is how the tool will be called by the model and in `tool_use` blocks.
     */
    #[Api]
    public string $name = 'computer';

    #[Api]
    public string $type = 'computer_20241022';

    /**
     * The height of the display in pixels.
     */
    #[Api('display_height_px')]
    public int $displayHeightPx;

    /**
     * The width of the display in pixels.
     */
    #[Api('display_width_px')]
    public int $displayWidthPx;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    #[Api('display_number', nullable: true, optional: true)]
    public ?int $displayNumber;

    /**
     * `new BetaToolComputerUse20241022()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolComputerUse20241022::with(displayHeightPx: ..., displayWidthPx: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolComputerUse20241022)
     *   ->withDisplayHeightPx(...)
     *   ->withDisplayWidthPx(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        int $displayHeightPx,
        int $displayWidthPx,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?int $displayNumber = null,
    ): self {
        $obj = new self;

        $obj->displayHeightPx = $displayHeightPx;
        $obj->displayWidthPx = $displayWidthPx;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $displayNumber && $obj->displayNumber = $displayNumber;

        return $obj;
    }

    /**
     * The height of the display in pixels.
     */
    public function withDisplayHeightPx(int $displayHeightPx): self
    {
        $obj = clone $this;
        $obj->displayHeightPx = $displayHeightPx;

        return $obj;
    }

    /**
     * The width of the display in pixels.
     */
    public function withDisplayWidthPx(int $displayWidthPx): self
    {
        $obj = clone $this;
        $obj->displayWidthPx = $displayWidthPx;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    public function withDisplayNumber(?int $displayNumber): self
    {
        $obj = clone $this;
        $obj->displayNumber = $displayNumber;

        return $obj;
    }
}
