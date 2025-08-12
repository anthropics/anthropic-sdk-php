<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_tool_computer_use20241022_alias = array{
 *   displayHeightPx: int,
 *   displayWidthPx: int,
 *   name: string,
 *   type: string,
 *   cacheControl?: BetaCacheControlEphemeral,
 *   displayNumber?: int|null,
 * }
 */
final class BetaToolComputerUse20241022 implements BaseModel
{
    use Model;

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
    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    #[Api('display_number', optional: true)]
    public ?int $displayNumber;

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
    public static function from(
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
    public function setDisplayHeightPx(int $displayHeightPx): self
    {
        $this->displayHeightPx = $displayHeightPx;

        return $this;
    }

    /**
     * The width of the display in pixels.
     */
    public function setDisplayWidthPx(int $displayWidthPx): self
    {
        $this->displayWidthPx = $displayWidthPx;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    /**
     * The X11 display number (e.g. 0, 1) for the display.
     */
    public function setDisplayNumber(?int $displayNumber): self
    {
        $this->displayNumber = $displayNumber;

        return $this;
    }
}
