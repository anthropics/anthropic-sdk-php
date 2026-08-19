<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801;

use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\CursorPosition;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\DoubleClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\HoldKey;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Key;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftClickDrag;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftMouseDown;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftMouseUp;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\MiddleClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\MouseMove;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\RightClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Screenshot;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Scroll;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\TripleClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Type;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Wait;
use Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Zoom;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-member configuration for ``computer_toolset_20260801``: one
 * optional field per member tool, keyed by the member name — the same
 * name the member's ``tool_use`` blocks carry. Every member is an
 * accepted key, and a member's defaults apply wherever its key is
 * absent. Unknown keys are rejected: the field set is this toolset
 * version's complete member set.
 *
 * @phpstan-import-type CursorPositionShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\CursorPosition
 * @phpstan-import-type DoubleClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\DoubleClick
 * @phpstan-import-type HoldKeyShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\HoldKey
 * @phpstan-import-type KeyShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Key
 * @phpstan-import-type LeftClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftClick
 * @phpstan-import-type LeftClickDragShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftClickDrag
 * @phpstan-import-type LeftMouseDownShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftMouseDown
 * @phpstan-import-type LeftMouseUpShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\LeftMouseUp
 * @phpstan-import-type MiddleClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\MiddleClick
 * @phpstan-import-type MouseMoveShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\MouseMove
 * @phpstan-import-type RightClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\RightClick
 * @phpstan-import-type ScreenshotShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Screenshot
 * @phpstan-import-type ScrollShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Scroll
 * @phpstan-import-type TripleClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\TripleClick
 * @phpstan-import-type TypeShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Type
 * @phpstan-import-type WaitShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Wait
 * @phpstan-import-type ZoomShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaComputerToolset20260801\Configs\Zoom
 *
 * @phpstan-type ConfigsShape = array{
 *   cursorPosition?: null|CursorPosition|CursorPositionShape,
 *   doubleClick?: null|DoubleClick|DoubleClickShape,
 *   holdKey?: null|HoldKey|HoldKeyShape,
 *   key?: null|Key|KeyShape,
 *   leftClick?: null|LeftClick|LeftClickShape,
 *   leftClickDrag?: null|LeftClickDrag|LeftClickDragShape,
 *   leftMouseDown?: null|LeftMouseDown|LeftMouseDownShape,
 *   leftMouseUp?: null|LeftMouseUp|LeftMouseUpShape,
 *   middleClick?: null|MiddleClick|MiddleClickShape,
 *   mouseMove?: null|MouseMove|MouseMoveShape,
 *   rightClick?: null|RightClick|RightClickShape,
 *   screenshot?: null|Screenshot|ScreenshotShape,
 *   scroll?: null|Scroll|ScrollShape,
 *   tripleClick?: null|TripleClick|TripleClickShape,
 *   type?: null|Type|TypeShape,
 *   wait?: null|Wait|WaitShape,
 *   zoom?: null|Zoom|ZoomShape,
 * }
 */
final class Configs implements BaseModel
{
    /** @use SdkModel<ConfigsShape> */
    use SdkModel;

    /**
     * ``cursor_position``'s config overrides.
     */
    #[Optional('cursor_position', nullable: true)]
    public ?CursorPosition $cursorPosition;

    /**
     * ``double_click``'s config overrides.
     */
    #[Optional('double_click', nullable: true)]
    public ?DoubleClick $doubleClick;

    /**
     * ``hold_key``'s config overrides.
     */
    #[Optional('hold_key', nullable: true)]
    public ?HoldKey $holdKey;

    /**
     * ``key``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Key $key;

    /**
     * ``left_click``'s config overrides.
     */
    #[Optional('left_click', nullable: true)]
    public ?LeftClick $leftClick;

    /**
     * ``left_click_drag``'s config overrides.
     */
    #[Optional('left_click_drag', nullable: true)]
    public ?LeftClickDrag $leftClickDrag;

    /**
     * ``left_mouse_down``'s config overrides.
     */
    #[Optional('left_mouse_down', nullable: true)]
    public ?LeftMouseDown $leftMouseDown;

    /**
     * ``left_mouse_up``'s config overrides.
     */
    #[Optional('left_mouse_up', nullable: true)]
    public ?LeftMouseUp $leftMouseUp;

    /**
     * ``middle_click``'s config overrides.
     */
    #[Optional('middle_click', nullable: true)]
    public ?MiddleClick $middleClick;

    /**
     * ``mouse_move``'s config overrides.
     */
    #[Optional('mouse_move', nullable: true)]
    public ?MouseMove $mouseMove;

    /**
     * ``right_click``'s config overrides.
     */
    #[Optional('right_click', nullable: true)]
    public ?RightClick $rightClick;

    /**
     * ``screenshot``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Screenshot $screenshot;

    /**
     * ``scroll``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Scroll $scroll;

    /**
     * ``triple_click``'s config overrides.
     */
    #[Optional('triple_click', nullable: true)]
    public ?TripleClick $tripleClick;

    /**
     * ``type``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Type $type;

    /**
     * ``wait``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Wait $wait;

    /**
     * ``zoom``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Zoom $zoom;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param CursorPosition|CursorPositionShape|null $cursorPosition
     * @param DoubleClick|DoubleClickShape|null $doubleClick
     * @param HoldKey|HoldKeyShape|null $holdKey
     * @param Key|KeyShape|null $key
     * @param LeftClick|LeftClickShape|null $leftClick
     * @param LeftClickDrag|LeftClickDragShape|null $leftClickDrag
     * @param LeftMouseDown|LeftMouseDownShape|null $leftMouseDown
     * @param LeftMouseUp|LeftMouseUpShape|null $leftMouseUp
     * @param MiddleClick|MiddleClickShape|null $middleClick
     * @param MouseMove|MouseMoveShape|null $mouseMove
     * @param RightClick|RightClickShape|null $rightClick
     * @param Screenshot|ScreenshotShape|null $screenshot
     * @param Scroll|ScrollShape|null $scroll
     * @param TripleClick|TripleClickShape|null $tripleClick
     * @param Type|TypeShape|null $type
     * @param Wait|WaitShape|null $wait
     * @param Zoom|ZoomShape|null $zoom
     */
    public static function with(
        CursorPosition|array|null $cursorPosition = null,
        DoubleClick|array|null $doubleClick = null,
        HoldKey|array|null $holdKey = null,
        Key|array|null $key = null,
        LeftClick|array|null $leftClick = null,
        LeftClickDrag|array|null $leftClickDrag = null,
        LeftMouseDown|array|null $leftMouseDown = null,
        LeftMouseUp|array|null $leftMouseUp = null,
        MiddleClick|array|null $middleClick = null,
        MouseMove|array|null $mouseMove = null,
        RightClick|array|null $rightClick = null,
        Screenshot|array|null $screenshot = null,
        Scroll|array|null $scroll = null,
        TripleClick|array|null $tripleClick = null,
        Type|array|null $type = null,
        Wait|array|null $wait = null,
        Zoom|array|null $zoom = null,
    ): self {
        $self = new self;

        null !== $cursorPosition && $self['cursorPosition'] = $cursorPosition;
        null !== $doubleClick && $self['doubleClick'] = $doubleClick;
        null !== $holdKey && $self['holdKey'] = $holdKey;
        null !== $key && $self['key'] = $key;
        null !== $leftClick && $self['leftClick'] = $leftClick;
        null !== $leftClickDrag && $self['leftClickDrag'] = $leftClickDrag;
        null !== $leftMouseDown && $self['leftMouseDown'] = $leftMouseDown;
        null !== $leftMouseUp && $self['leftMouseUp'] = $leftMouseUp;
        null !== $middleClick && $self['middleClick'] = $middleClick;
        null !== $mouseMove && $self['mouseMove'] = $mouseMove;
        null !== $rightClick && $self['rightClick'] = $rightClick;
        null !== $screenshot && $self['screenshot'] = $screenshot;
        null !== $scroll && $self['scroll'] = $scroll;
        null !== $tripleClick && $self['tripleClick'] = $tripleClick;
        null !== $type && $self['type'] = $type;
        null !== $wait && $self['wait'] = $wait;
        null !== $zoom && $self['zoom'] = $zoom;

        return $self;
    }

    /**
     * ``cursor_position``'s config overrides.
     *
     * @param CursorPosition|CursorPositionShape|null $cursorPosition
     */
    public function withCursorPosition(
        CursorPosition|array|null $cursorPosition
    ): self {
        $self = clone $this;
        $self['cursorPosition'] = $cursorPosition;

        return $self;
    }

    /**
     * ``double_click``'s config overrides.
     *
     * @param DoubleClick|DoubleClickShape|null $doubleClick
     */
    public function withDoubleClick(DoubleClick|array|null $doubleClick): self
    {
        $self = clone $this;
        $self['doubleClick'] = $doubleClick;

        return $self;
    }

    /**
     * ``hold_key``'s config overrides.
     *
     * @param HoldKey|HoldKeyShape|null $holdKey
     */
    public function withHoldKey(HoldKey|array|null $holdKey): self
    {
        $self = clone $this;
        $self['holdKey'] = $holdKey;

        return $self;
    }

    /**
     * ``key``'s config overrides.
     *
     * @param Key|KeyShape|null $key
     */
    public function withKey(Key|array|null $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * ``left_click``'s config overrides.
     *
     * @param LeftClick|LeftClickShape|null $leftClick
     */
    public function withLeftClick(LeftClick|array|null $leftClick): self
    {
        $self = clone $this;
        $self['leftClick'] = $leftClick;

        return $self;
    }

    /**
     * ``left_click_drag``'s config overrides.
     *
     * @param LeftClickDrag|LeftClickDragShape|null $leftClickDrag
     */
    public function withLeftClickDrag(
        LeftClickDrag|array|null $leftClickDrag
    ): self {
        $self = clone $this;
        $self['leftClickDrag'] = $leftClickDrag;

        return $self;
    }

    /**
     * ``left_mouse_down``'s config overrides.
     *
     * @param LeftMouseDown|LeftMouseDownShape|null $leftMouseDown
     */
    public function withLeftMouseDown(
        LeftMouseDown|array|null $leftMouseDown
    ): self {
        $self = clone $this;
        $self['leftMouseDown'] = $leftMouseDown;

        return $self;
    }

    /**
     * ``left_mouse_up``'s config overrides.
     *
     * @param LeftMouseUp|LeftMouseUpShape|null $leftMouseUp
     */
    public function withLeftMouseUp(LeftMouseUp|array|null $leftMouseUp): self
    {
        $self = clone $this;
        $self['leftMouseUp'] = $leftMouseUp;

        return $self;
    }

    /**
     * ``middle_click``'s config overrides.
     *
     * @param MiddleClick|MiddleClickShape|null $middleClick
     */
    public function withMiddleClick(MiddleClick|array|null $middleClick): self
    {
        $self = clone $this;
        $self['middleClick'] = $middleClick;

        return $self;
    }

    /**
     * ``mouse_move``'s config overrides.
     *
     * @param MouseMove|MouseMoveShape|null $mouseMove
     */
    public function withMouseMove(MouseMove|array|null $mouseMove): self
    {
        $self = clone $this;
        $self['mouseMove'] = $mouseMove;

        return $self;
    }

    /**
     * ``right_click``'s config overrides.
     *
     * @param RightClick|RightClickShape|null $rightClick
     */
    public function withRightClick(RightClick|array|null $rightClick): self
    {
        $self = clone $this;
        $self['rightClick'] = $rightClick;

        return $self;
    }

    /**
     * ``screenshot``'s config overrides.
     *
     * @param Screenshot|ScreenshotShape|null $screenshot
     */
    public function withScreenshot(Screenshot|array|null $screenshot): self
    {
        $self = clone $this;
        $self['screenshot'] = $screenshot;

        return $self;
    }

    /**
     * ``scroll``'s config overrides.
     *
     * @param Scroll|ScrollShape|null $scroll
     */
    public function withScroll(Scroll|array|null $scroll): self
    {
        $self = clone $this;
        $self['scroll'] = $scroll;

        return $self;
    }

    /**
     * ``triple_click``'s config overrides.
     *
     * @param TripleClick|TripleClickShape|null $tripleClick
     */
    public function withTripleClick(TripleClick|array|null $tripleClick): self
    {
        $self = clone $this;
        $self['tripleClick'] = $tripleClick;

        return $self;
    }

    /**
     * ``type``'s config overrides.
     *
     * @param Type|TypeShape|null $type
     */
    public function withType(Type|array|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ``wait``'s config overrides.
     *
     * @param Wait|WaitShape|null $wait
     */
    public function withWait(Wait|array|null $wait): self
    {
        $self = clone $this;
        $self['wait'] = $wait;

        return $self;
    }

    /**
     * ``zoom``'s config overrides.
     *
     * @param Zoom|ZoomShape|null $zoom
     */
    public function withZoom(Zoom|array|null $zoom): self
    {
        $self = clone $this;
        $self['zoom'] = $zoom;

        return $self;
    }
}
