<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

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
 * @phpstan-import-type BetaComputerCursorPositionConfigShape from \Anthropic\Beta\Messages\BetaComputerCursorPositionConfig
 * @phpstan-import-type BetaComputerDoubleClickConfigShape from \Anthropic\Beta\Messages\BetaComputerDoubleClickConfig
 * @phpstan-import-type BetaComputerHoldKeyConfigShape from \Anthropic\Beta\Messages\BetaComputerHoldKeyConfig
 * @phpstan-import-type BetaComputerKeyConfigShape from \Anthropic\Beta\Messages\BetaComputerKeyConfig
 * @phpstan-import-type BetaComputerLeftClickConfigShape from \Anthropic\Beta\Messages\BetaComputerLeftClickConfig
 * @phpstan-import-type BetaComputerLeftClickDragConfigShape from \Anthropic\Beta\Messages\BetaComputerLeftClickDragConfig
 * @phpstan-import-type BetaComputerLeftMouseDownConfigShape from \Anthropic\Beta\Messages\BetaComputerLeftMouseDownConfig
 * @phpstan-import-type BetaComputerLeftMouseUpConfigShape from \Anthropic\Beta\Messages\BetaComputerLeftMouseUpConfig
 * @phpstan-import-type BetaComputerMiddleClickConfigShape from \Anthropic\Beta\Messages\BetaComputerMiddleClickConfig
 * @phpstan-import-type BetaComputerMouseMoveConfigShape from \Anthropic\Beta\Messages\BetaComputerMouseMoveConfig
 * @phpstan-import-type BetaComputerRightClickConfigShape from \Anthropic\Beta\Messages\BetaComputerRightClickConfig
 * @phpstan-import-type BetaComputerScreenshotConfigShape from \Anthropic\Beta\Messages\BetaComputerScreenshotConfig
 * @phpstan-import-type BetaComputerScrollConfigShape from \Anthropic\Beta\Messages\BetaComputerScrollConfig
 * @phpstan-import-type BetaComputerTripleClickConfigShape from \Anthropic\Beta\Messages\BetaComputerTripleClickConfig
 * @phpstan-import-type BetaComputerTypeConfigShape from \Anthropic\Beta\Messages\BetaComputerTypeConfig
 * @phpstan-import-type BetaComputerWaitConfigShape from \Anthropic\Beta\Messages\BetaComputerWaitConfig
 * @phpstan-import-type BetaComputerZoomConfigShape from \Anthropic\Beta\Messages\BetaComputerZoomConfig
 *
 * @phpstan-type BetaComputerToolsetConfigsShape = array{
 *   cursorPosition?: null|BetaComputerCursorPositionConfig|BetaComputerCursorPositionConfigShape,
 *   doubleClick?: null|BetaComputerDoubleClickConfig|BetaComputerDoubleClickConfigShape,
 *   holdKey?: null|BetaComputerHoldKeyConfig|BetaComputerHoldKeyConfigShape,
 *   key?: null|BetaComputerKeyConfig|BetaComputerKeyConfigShape,
 *   leftClick?: null|BetaComputerLeftClickConfig|BetaComputerLeftClickConfigShape,
 *   leftClickDrag?: null|BetaComputerLeftClickDragConfig|BetaComputerLeftClickDragConfigShape,
 *   leftMouseDown?: null|BetaComputerLeftMouseDownConfig|BetaComputerLeftMouseDownConfigShape,
 *   leftMouseUp?: null|BetaComputerLeftMouseUpConfig|BetaComputerLeftMouseUpConfigShape,
 *   middleClick?: null|BetaComputerMiddleClickConfig|BetaComputerMiddleClickConfigShape,
 *   mouseMove?: null|BetaComputerMouseMoveConfig|BetaComputerMouseMoveConfigShape,
 *   rightClick?: null|BetaComputerRightClickConfig|BetaComputerRightClickConfigShape,
 *   screenshot?: null|BetaComputerScreenshotConfig|BetaComputerScreenshotConfigShape,
 *   scroll?: null|BetaComputerScrollConfig|BetaComputerScrollConfigShape,
 *   tripleClick?: null|BetaComputerTripleClickConfig|BetaComputerTripleClickConfigShape,
 *   type?: null|BetaComputerTypeConfig|BetaComputerTypeConfigShape,
 *   wait?: null|BetaComputerWaitConfig|BetaComputerWaitConfigShape,
 *   zoom?: null|BetaComputerZoomConfig|BetaComputerZoomConfigShape,
 * }
 */
final class BetaComputerToolsetConfigs implements BaseModel
{
    /** @use SdkModel<BetaComputerToolsetConfigsShape> */
    use SdkModel;

    /**
     * ``cursor_position``'s config overrides.
     */
    #[Optional('cursor_position', nullable: true)]
    public ?BetaComputerCursorPositionConfig $cursorPosition;

    /**
     * ``double_click``'s config overrides.
     */
    #[Optional('double_click', nullable: true)]
    public ?BetaComputerDoubleClickConfig $doubleClick;

    /**
     * ``hold_key``'s config overrides.
     */
    #[Optional('hold_key', nullable: true)]
    public ?BetaComputerHoldKeyConfig $holdKey;

    /**
     * ``key``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaComputerKeyConfig $key;

    /**
     * ``left_click``'s config overrides.
     */
    #[Optional('left_click', nullable: true)]
    public ?BetaComputerLeftClickConfig $leftClick;

    /**
     * ``left_click_drag``'s config overrides.
     */
    #[Optional('left_click_drag', nullable: true)]
    public ?BetaComputerLeftClickDragConfig $leftClickDrag;

    /**
     * ``left_mouse_down``'s config overrides.
     */
    #[Optional('left_mouse_down', nullable: true)]
    public ?BetaComputerLeftMouseDownConfig $leftMouseDown;

    /**
     * ``left_mouse_up``'s config overrides.
     */
    #[Optional('left_mouse_up', nullable: true)]
    public ?BetaComputerLeftMouseUpConfig $leftMouseUp;

    /**
     * ``middle_click``'s config overrides.
     */
    #[Optional('middle_click', nullable: true)]
    public ?BetaComputerMiddleClickConfig $middleClick;

    /**
     * ``mouse_move``'s config overrides.
     */
    #[Optional('mouse_move', nullable: true)]
    public ?BetaComputerMouseMoveConfig $mouseMove;

    /**
     * ``right_click``'s config overrides.
     */
    #[Optional('right_click', nullable: true)]
    public ?BetaComputerRightClickConfig $rightClick;

    /**
     * ``screenshot``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaComputerScreenshotConfig $screenshot;

    /**
     * ``scroll``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaComputerScrollConfig $scroll;

    /**
     * ``triple_click``'s config overrides.
     */
    #[Optional('triple_click', nullable: true)]
    public ?BetaComputerTripleClickConfig $tripleClick;

    /**
     * ``type``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaComputerTypeConfig $type;

    /**
     * ``wait``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaComputerWaitConfig $wait;

    /**
     * ``zoom``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaComputerZoomConfig $zoom;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaComputerCursorPositionConfig|BetaComputerCursorPositionConfigShape|null $cursorPosition
     * @param BetaComputerDoubleClickConfig|BetaComputerDoubleClickConfigShape|null $doubleClick
     * @param BetaComputerHoldKeyConfig|BetaComputerHoldKeyConfigShape|null $holdKey
     * @param BetaComputerKeyConfig|BetaComputerKeyConfigShape|null $key
     * @param BetaComputerLeftClickConfig|BetaComputerLeftClickConfigShape|null $leftClick
     * @param BetaComputerLeftClickDragConfig|BetaComputerLeftClickDragConfigShape|null $leftClickDrag
     * @param BetaComputerLeftMouseDownConfig|BetaComputerLeftMouseDownConfigShape|null $leftMouseDown
     * @param BetaComputerLeftMouseUpConfig|BetaComputerLeftMouseUpConfigShape|null $leftMouseUp
     * @param BetaComputerMiddleClickConfig|BetaComputerMiddleClickConfigShape|null $middleClick
     * @param BetaComputerMouseMoveConfig|BetaComputerMouseMoveConfigShape|null $mouseMove
     * @param BetaComputerRightClickConfig|BetaComputerRightClickConfigShape|null $rightClick
     * @param BetaComputerScreenshotConfig|BetaComputerScreenshotConfigShape|null $screenshot
     * @param BetaComputerScrollConfig|BetaComputerScrollConfigShape|null $scroll
     * @param BetaComputerTripleClickConfig|BetaComputerTripleClickConfigShape|null $tripleClick
     * @param BetaComputerTypeConfig|BetaComputerTypeConfigShape|null $type
     * @param BetaComputerWaitConfig|BetaComputerWaitConfigShape|null $wait
     * @param BetaComputerZoomConfig|BetaComputerZoomConfigShape|null $zoom
     */
    public static function with(
        BetaComputerCursorPositionConfig|array|null $cursorPosition = null,
        BetaComputerDoubleClickConfig|array|null $doubleClick = null,
        BetaComputerHoldKeyConfig|array|null $holdKey = null,
        BetaComputerKeyConfig|array|null $key = null,
        BetaComputerLeftClickConfig|array|null $leftClick = null,
        BetaComputerLeftClickDragConfig|array|null $leftClickDrag = null,
        BetaComputerLeftMouseDownConfig|array|null $leftMouseDown = null,
        BetaComputerLeftMouseUpConfig|array|null $leftMouseUp = null,
        BetaComputerMiddleClickConfig|array|null $middleClick = null,
        BetaComputerMouseMoveConfig|array|null $mouseMove = null,
        BetaComputerRightClickConfig|array|null $rightClick = null,
        BetaComputerScreenshotConfig|array|null $screenshot = null,
        BetaComputerScrollConfig|array|null $scroll = null,
        BetaComputerTripleClickConfig|array|null $tripleClick = null,
        BetaComputerTypeConfig|array|null $type = null,
        BetaComputerWaitConfig|array|null $wait = null,
        BetaComputerZoomConfig|array|null $zoom = null,
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
     * @param BetaComputerCursorPositionConfig|BetaComputerCursorPositionConfigShape|null $cursorPosition
     */
    public function withCursorPosition(
        BetaComputerCursorPositionConfig|array|null $cursorPosition
    ): self {
        $self = clone $this;
        $self['cursorPosition'] = $cursorPosition;

        return $self;
    }

    /**
     * ``double_click``'s config overrides.
     *
     * @param BetaComputerDoubleClickConfig|BetaComputerDoubleClickConfigShape|null $doubleClick
     */
    public function withDoubleClick(
        BetaComputerDoubleClickConfig|array|null $doubleClick
    ): self {
        $self = clone $this;
        $self['doubleClick'] = $doubleClick;

        return $self;
    }

    /**
     * ``hold_key``'s config overrides.
     *
     * @param BetaComputerHoldKeyConfig|BetaComputerHoldKeyConfigShape|null $holdKey
     */
    public function withHoldKey(
        BetaComputerHoldKeyConfig|array|null $holdKey
    ): self {
        $self = clone $this;
        $self['holdKey'] = $holdKey;

        return $self;
    }

    /**
     * ``key``'s config overrides.
     *
     * @param BetaComputerKeyConfig|BetaComputerKeyConfigShape|null $key
     */
    public function withKey(BetaComputerKeyConfig|array|null $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * ``left_click``'s config overrides.
     *
     * @param BetaComputerLeftClickConfig|BetaComputerLeftClickConfigShape|null $leftClick
     */
    public function withLeftClick(
        BetaComputerLeftClickConfig|array|null $leftClick
    ): self {
        $self = clone $this;
        $self['leftClick'] = $leftClick;

        return $self;
    }

    /**
     * ``left_click_drag``'s config overrides.
     *
     * @param BetaComputerLeftClickDragConfig|BetaComputerLeftClickDragConfigShape|null $leftClickDrag
     */
    public function withLeftClickDrag(
        BetaComputerLeftClickDragConfig|array|null $leftClickDrag
    ): self {
        $self = clone $this;
        $self['leftClickDrag'] = $leftClickDrag;

        return $self;
    }

    /**
     * ``left_mouse_down``'s config overrides.
     *
     * @param BetaComputerLeftMouseDownConfig|BetaComputerLeftMouseDownConfigShape|null $leftMouseDown
     */
    public function withLeftMouseDown(
        BetaComputerLeftMouseDownConfig|array|null $leftMouseDown
    ): self {
        $self = clone $this;
        $self['leftMouseDown'] = $leftMouseDown;

        return $self;
    }

    /**
     * ``left_mouse_up``'s config overrides.
     *
     * @param BetaComputerLeftMouseUpConfig|BetaComputerLeftMouseUpConfigShape|null $leftMouseUp
     */
    public function withLeftMouseUp(
        BetaComputerLeftMouseUpConfig|array|null $leftMouseUp
    ): self {
        $self = clone $this;
        $self['leftMouseUp'] = $leftMouseUp;

        return $self;
    }

    /**
     * ``middle_click``'s config overrides.
     *
     * @param BetaComputerMiddleClickConfig|BetaComputerMiddleClickConfigShape|null $middleClick
     */
    public function withMiddleClick(
        BetaComputerMiddleClickConfig|array|null $middleClick
    ): self {
        $self = clone $this;
        $self['middleClick'] = $middleClick;

        return $self;
    }

    /**
     * ``mouse_move``'s config overrides.
     *
     * @param BetaComputerMouseMoveConfig|BetaComputerMouseMoveConfigShape|null $mouseMove
     */
    public function withMouseMove(
        BetaComputerMouseMoveConfig|array|null $mouseMove
    ): self {
        $self = clone $this;
        $self['mouseMove'] = $mouseMove;

        return $self;
    }

    /**
     * ``right_click``'s config overrides.
     *
     * @param BetaComputerRightClickConfig|BetaComputerRightClickConfigShape|null $rightClick
     */
    public function withRightClick(
        BetaComputerRightClickConfig|array|null $rightClick
    ): self {
        $self = clone $this;
        $self['rightClick'] = $rightClick;

        return $self;
    }

    /**
     * ``screenshot``'s config overrides.
     *
     * @param BetaComputerScreenshotConfig|BetaComputerScreenshotConfigShape|null $screenshot
     */
    public function withScreenshot(
        BetaComputerScreenshotConfig|array|null $screenshot
    ): self {
        $self = clone $this;
        $self['screenshot'] = $screenshot;

        return $self;
    }

    /**
     * ``scroll``'s config overrides.
     *
     * @param BetaComputerScrollConfig|BetaComputerScrollConfigShape|null $scroll
     */
    public function withScroll(
        BetaComputerScrollConfig|array|null $scroll
    ): self {
        $self = clone $this;
        $self['scroll'] = $scroll;

        return $self;
    }

    /**
     * ``triple_click``'s config overrides.
     *
     * @param BetaComputerTripleClickConfig|BetaComputerTripleClickConfigShape|null $tripleClick
     */
    public function withTripleClick(
        BetaComputerTripleClickConfig|array|null $tripleClick
    ): self {
        $self = clone $this;
        $self['tripleClick'] = $tripleClick;

        return $self;
    }

    /**
     * ``type``'s config overrides.
     *
     * @param BetaComputerTypeConfig|BetaComputerTypeConfigShape|null $type
     */
    public function withType(BetaComputerTypeConfig|array|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ``wait``'s config overrides.
     *
     * @param BetaComputerWaitConfig|BetaComputerWaitConfigShape|null $wait
     */
    public function withWait(BetaComputerWaitConfig|array|null $wait): self
    {
        $self = clone $this;
        $self['wait'] = $wait;

        return $self;
    }

    /**
     * ``zoom``'s config overrides.
     *
     * @param BetaComputerZoomConfig|BetaComputerZoomConfigShape|null $zoom
     */
    public function withZoom(BetaComputerZoomConfig|array|null $zoom): self
    {
        $self = clone $this;
        $self['zoom'] = $zoom;

        return $self;
    }
}
