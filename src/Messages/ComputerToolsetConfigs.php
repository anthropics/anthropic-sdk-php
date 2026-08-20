<?php

declare(strict_types=1);

namespace Anthropic\Messages;

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
 * @phpstan-import-type ComputerCursorPositionConfigShape from \Anthropic\Messages\ComputerCursorPositionConfig
 * @phpstan-import-type ComputerDoubleClickConfigShape from \Anthropic\Messages\ComputerDoubleClickConfig
 * @phpstan-import-type ComputerHoldKeyConfigShape from \Anthropic\Messages\ComputerHoldKeyConfig
 * @phpstan-import-type ComputerKeyConfigShape from \Anthropic\Messages\ComputerKeyConfig
 * @phpstan-import-type ComputerLeftClickConfigShape from \Anthropic\Messages\ComputerLeftClickConfig
 * @phpstan-import-type ComputerLeftClickDragConfigShape from \Anthropic\Messages\ComputerLeftClickDragConfig
 * @phpstan-import-type ComputerLeftMouseDownConfigShape from \Anthropic\Messages\ComputerLeftMouseDownConfig
 * @phpstan-import-type ComputerLeftMouseUpConfigShape from \Anthropic\Messages\ComputerLeftMouseUpConfig
 * @phpstan-import-type ComputerMiddleClickConfigShape from \Anthropic\Messages\ComputerMiddleClickConfig
 * @phpstan-import-type ComputerMouseMoveConfigShape from \Anthropic\Messages\ComputerMouseMoveConfig
 * @phpstan-import-type ComputerRightClickConfigShape from \Anthropic\Messages\ComputerRightClickConfig
 * @phpstan-import-type ComputerScreenshotConfigShape from \Anthropic\Messages\ComputerScreenshotConfig
 * @phpstan-import-type ComputerScrollConfigShape from \Anthropic\Messages\ComputerScrollConfig
 * @phpstan-import-type ComputerTripleClickConfigShape from \Anthropic\Messages\ComputerTripleClickConfig
 * @phpstan-import-type ComputerTypeConfigShape from \Anthropic\Messages\ComputerTypeConfig
 * @phpstan-import-type ComputerWaitConfigShape from \Anthropic\Messages\ComputerWaitConfig
 * @phpstan-import-type ComputerZoomConfigShape from \Anthropic\Messages\ComputerZoomConfig
 *
 * @phpstan-type ComputerToolsetConfigsShape = array{
 *   cursorPosition?: null|ComputerCursorPositionConfig|ComputerCursorPositionConfigShape,
 *   doubleClick?: null|ComputerDoubleClickConfig|ComputerDoubleClickConfigShape,
 *   holdKey?: null|ComputerHoldKeyConfig|ComputerHoldKeyConfigShape,
 *   key?: null|ComputerKeyConfig|ComputerKeyConfigShape,
 *   leftClick?: null|ComputerLeftClickConfig|ComputerLeftClickConfigShape,
 *   leftClickDrag?: null|ComputerLeftClickDragConfig|ComputerLeftClickDragConfigShape,
 *   leftMouseDown?: null|ComputerLeftMouseDownConfig|ComputerLeftMouseDownConfigShape,
 *   leftMouseUp?: null|ComputerLeftMouseUpConfig|ComputerLeftMouseUpConfigShape,
 *   middleClick?: null|ComputerMiddleClickConfig|ComputerMiddleClickConfigShape,
 *   mouseMove?: null|ComputerMouseMoveConfig|ComputerMouseMoveConfigShape,
 *   rightClick?: null|ComputerRightClickConfig|ComputerRightClickConfigShape,
 *   screenshot?: null|ComputerScreenshotConfig|ComputerScreenshotConfigShape,
 *   scroll?: null|ComputerScrollConfig|ComputerScrollConfigShape,
 *   tripleClick?: null|ComputerTripleClickConfig|ComputerTripleClickConfigShape,
 *   type?: null|ComputerTypeConfig|ComputerTypeConfigShape,
 *   wait?: null|ComputerWaitConfig|ComputerWaitConfigShape,
 *   zoom?: null|ComputerZoomConfig|ComputerZoomConfigShape,
 * }
 */
final class ComputerToolsetConfigs implements BaseModel
{
    /** @use SdkModel<ComputerToolsetConfigsShape> */
    use SdkModel;

    /**
     * ``cursor_position``'s config overrides.
     */
    #[Optional('cursor_position', nullable: true)]
    public ?ComputerCursorPositionConfig $cursorPosition;

    /**
     * ``double_click``'s config overrides.
     */
    #[Optional('double_click', nullable: true)]
    public ?ComputerDoubleClickConfig $doubleClick;

    /**
     * ``hold_key``'s config overrides.
     */
    #[Optional('hold_key', nullable: true)]
    public ?ComputerHoldKeyConfig $holdKey;

    /**
     * ``key``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?ComputerKeyConfig $key;

    /**
     * ``left_click``'s config overrides.
     */
    #[Optional('left_click', nullable: true)]
    public ?ComputerLeftClickConfig $leftClick;

    /**
     * ``left_click_drag``'s config overrides.
     */
    #[Optional('left_click_drag', nullable: true)]
    public ?ComputerLeftClickDragConfig $leftClickDrag;

    /**
     * ``left_mouse_down``'s config overrides.
     */
    #[Optional('left_mouse_down', nullable: true)]
    public ?ComputerLeftMouseDownConfig $leftMouseDown;

    /**
     * ``left_mouse_up``'s config overrides.
     */
    #[Optional('left_mouse_up', nullable: true)]
    public ?ComputerLeftMouseUpConfig $leftMouseUp;

    /**
     * ``middle_click``'s config overrides.
     */
    #[Optional('middle_click', nullable: true)]
    public ?ComputerMiddleClickConfig $middleClick;

    /**
     * ``mouse_move``'s config overrides.
     */
    #[Optional('mouse_move', nullable: true)]
    public ?ComputerMouseMoveConfig $mouseMove;

    /**
     * ``right_click``'s config overrides.
     */
    #[Optional('right_click', nullable: true)]
    public ?ComputerRightClickConfig $rightClick;

    /**
     * ``screenshot``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?ComputerScreenshotConfig $screenshot;

    /**
     * ``scroll``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?ComputerScrollConfig $scroll;

    /**
     * ``triple_click``'s config overrides.
     */
    #[Optional('triple_click', nullable: true)]
    public ?ComputerTripleClickConfig $tripleClick;

    /**
     * ``type``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?ComputerTypeConfig $type;

    /**
     * ``wait``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?ComputerWaitConfig $wait;

    /**
     * ``zoom``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?ComputerZoomConfig $zoom;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ComputerCursorPositionConfig|ComputerCursorPositionConfigShape|null $cursorPosition
     * @param ComputerDoubleClickConfig|ComputerDoubleClickConfigShape|null $doubleClick
     * @param ComputerHoldKeyConfig|ComputerHoldKeyConfigShape|null $holdKey
     * @param ComputerKeyConfig|ComputerKeyConfigShape|null $key
     * @param ComputerLeftClickConfig|ComputerLeftClickConfigShape|null $leftClick
     * @param ComputerLeftClickDragConfig|ComputerLeftClickDragConfigShape|null $leftClickDrag
     * @param ComputerLeftMouseDownConfig|ComputerLeftMouseDownConfigShape|null $leftMouseDown
     * @param ComputerLeftMouseUpConfig|ComputerLeftMouseUpConfigShape|null $leftMouseUp
     * @param ComputerMiddleClickConfig|ComputerMiddleClickConfigShape|null $middleClick
     * @param ComputerMouseMoveConfig|ComputerMouseMoveConfigShape|null $mouseMove
     * @param ComputerRightClickConfig|ComputerRightClickConfigShape|null $rightClick
     * @param ComputerScreenshotConfig|ComputerScreenshotConfigShape|null $screenshot
     * @param ComputerScrollConfig|ComputerScrollConfigShape|null $scroll
     * @param ComputerTripleClickConfig|ComputerTripleClickConfigShape|null $tripleClick
     * @param ComputerTypeConfig|ComputerTypeConfigShape|null $type
     * @param ComputerWaitConfig|ComputerWaitConfigShape|null $wait
     * @param ComputerZoomConfig|ComputerZoomConfigShape|null $zoom
     */
    public static function with(
        ComputerCursorPositionConfig|array|null $cursorPosition = null,
        ComputerDoubleClickConfig|array|null $doubleClick = null,
        ComputerHoldKeyConfig|array|null $holdKey = null,
        ComputerKeyConfig|array|null $key = null,
        ComputerLeftClickConfig|array|null $leftClick = null,
        ComputerLeftClickDragConfig|array|null $leftClickDrag = null,
        ComputerLeftMouseDownConfig|array|null $leftMouseDown = null,
        ComputerLeftMouseUpConfig|array|null $leftMouseUp = null,
        ComputerMiddleClickConfig|array|null $middleClick = null,
        ComputerMouseMoveConfig|array|null $mouseMove = null,
        ComputerRightClickConfig|array|null $rightClick = null,
        ComputerScreenshotConfig|array|null $screenshot = null,
        ComputerScrollConfig|array|null $scroll = null,
        ComputerTripleClickConfig|array|null $tripleClick = null,
        ComputerTypeConfig|array|null $type = null,
        ComputerWaitConfig|array|null $wait = null,
        ComputerZoomConfig|array|null $zoom = null,
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
     * @param ComputerCursorPositionConfig|ComputerCursorPositionConfigShape|null $cursorPosition
     */
    public function withCursorPosition(
        ComputerCursorPositionConfig|array|null $cursorPosition
    ): self {
        $self = clone $this;
        $self['cursorPosition'] = $cursorPosition;

        return $self;
    }

    /**
     * ``double_click``'s config overrides.
     *
     * @param ComputerDoubleClickConfig|ComputerDoubleClickConfigShape|null $doubleClick
     */
    public function withDoubleClick(
        ComputerDoubleClickConfig|array|null $doubleClick
    ): self {
        $self = clone $this;
        $self['doubleClick'] = $doubleClick;

        return $self;
    }

    /**
     * ``hold_key``'s config overrides.
     *
     * @param ComputerHoldKeyConfig|ComputerHoldKeyConfigShape|null $holdKey
     */
    public function withHoldKey(ComputerHoldKeyConfig|array|null $holdKey): self
    {
        $self = clone $this;
        $self['holdKey'] = $holdKey;

        return $self;
    }

    /**
     * ``key``'s config overrides.
     *
     * @param ComputerKeyConfig|ComputerKeyConfigShape|null $key
     */
    public function withKey(ComputerKeyConfig|array|null $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * ``left_click``'s config overrides.
     *
     * @param ComputerLeftClickConfig|ComputerLeftClickConfigShape|null $leftClick
     */
    public function withLeftClick(
        ComputerLeftClickConfig|array|null $leftClick
    ): self {
        $self = clone $this;
        $self['leftClick'] = $leftClick;

        return $self;
    }

    /**
     * ``left_click_drag``'s config overrides.
     *
     * @param ComputerLeftClickDragConfig|ComputerLeftClickDragConfigShape|null $leftClickDrag
     */
    public function withLeftClickDrag(
        ComputerLeftClickDragConfig|array|null $leftClickDrag
    ): self {
        $self = clone $this;
        $self['leftClickDrag'] = $leftClickDrag;

        return $self;
    }

    /**
     * ``left_mouse_down``'s config overrides.
     *
     * @param ComputerLeftMouseDownConfig|ComputerLeftMouseDownConfigShape|null $leftMouseDown
     */
    public function withLeftMouseDown(
        ComputerLeftMouseDownConfig|array|null $leftMouseDown
    ): self {
        $self = clone $this;
        $self['leftMouseDown'] = $leftMouseDown;

        return $self;
    }

    /**
     * ``left_mouse_up``'s config overrides.
     *
     * @param ComputerLeftMouseUpConfig|ComputerLeftMouseUpConfigShape|null $leftMouseUp
     */
    public function withLeftMouseUp(
        ComputerLeftMouseUpConfig|array|null $leftMouseUp
    ): self {
        $self = clone $this;
        $self['leftMouseUp'] = $leftMouseUp;

        return $self;
    }

    /**
     * ``middle_click``'s config overrides.
     *
     * @param ComputerMiddleClickConfig|ComputerMiddleClickConfigShape|null $middleClick
     */
    public function withMiddleClick(
        ComputerMiddleClickConfig|array|null $middleClick
    ): self {
        $self = clone $this;
        $self['middleClick'] = $middleClick;

        return $self;
    }

    /**
     * ``mouse_move``'s config overrides.
     *
     * @param ComputerMouseMoveConfig|ComputerMouseMoveConfigShape|null $mouseMove
     */
    public function withMouseMove(
        ComputerMouseMoveConfig|array|null $mouseMove
    ): self {
        $self = clone $this;
        $self['mouseMove'] = $mouseMove;

        return $self;
    }

    /**
     * ``right_click``'s config overrides.
     *
     * @param ComputerRightClickConfig|ComputerRightClickConfigShape|null $rightClick
     */
    public function withRightClick(
        ComputerRightClickConfig|array|null $rightClick
    ): self {
        $self = clone $this;
        $self['rightClick'] = $rightClick;

        return $self;
    }

    /**
     * ``screenshot``'s config overrides.
     *
     * @param ComputerScreenshotConfig|ComputerScreenshotConfigShape|null $screenshot
     */
    public function withScreenshot(
        ComputerScreenshotConfig|array|null $screenshot
    ): self {
        $self = clone $this;
        $self['screenshot'] = $screenshot;

        return $self;
    }

    /**
     * ``scroll``'s config overrides.
     *
     * @param ComputerScrollConfig|ComputerScrollConfigShape|null $scroll
     */
    public function withScroll(ComputerScrollConfig|array|null $scroll): self
    {
        $self = clone $this;
        $self['scroll'] = $scroll;

        return $self;
    }

    /**
     * ``triple_click``'s config overrides.
     *
     * @param ComputerTripleClickConfig|ComputerTripleClickConfigShape|null $tripleClick
     */
    public function withTripleClick(
        ComputerTripleClickConfig|array|null $tripleClick
    ): self {
        $self = clone $this;
        $self['tripleClick'] = $tripleClick;

        return $self;
    }

    /**
     * ``type``'s config overrides.
     *
     * @param ComputerTypeConfig|ComputerTypeConfigShape|null $type
     */
    public function withType(ComputerTypeConfig|array|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ``wait``'s config overrides.
     *
     * @param ComputerWaitConfig|ComputerWaitConfigShape|null $wait
     */
    public function withWait(ComputerWaitConfig|array|null $wait): self
    {
        $self = clone $this;
        $self['wait'] = $wait;

        return $self;
    }

    /**
     * ``zoom``'s config overrides.
     *
     * @param ComputerZoomConfig|ComputerZoomConfigShape|null $zoom
     */
    public function withZoom(ComputerZoomConfig|array|null $zoom): self
    {
        $self = clone $this;
        $self['zoom'] = $zoom;

        return $self;
    }
}
