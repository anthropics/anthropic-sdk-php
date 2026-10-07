<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaComputerKeyToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerKeyToolUseBlock
 * @phpstan-import-type BetaComputerHoldKeyToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerHoldKeyToolUseBlock
 * @phpstan-import-type BetaComputerTypeToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerTypeToolUseBlock
 * @phpstan-import-type BetaComputerCursorPositionToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerCursorPositionToolUseBlock
 * @phpstan-import-type BetaComputerMouseMoveToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerMouseMoveToolUseBlock
 * @phpstan-import-type BetaComputerLeftMouseDownToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerLeftMouseDownToolUseBlock
 * @phpstan-import-type BetaComputerLeftMouseUpToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerLeftMouseUpToolUseBlock
 * @phpstan-import-type BetaComputerLeftClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerLeftClickToolUseBlock
 * @phpstan-import-type BetaComputerLeftClickDragToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerLeftClickDragToolUseBlock
 * @phpstan-import-type BetaComputerRightClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerRightClickToolUseBlock
 * @phpstan-import-type BetaComputerMiddleClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerMiddleClickToolUseBlock
 * @phpstan-import-type BetaComputerDoubleClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerDoubleClickToolUseBlock
 * @phpstan-import-type BetaComputerTripleClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerTripleClickToolUseBlock
 * @phpstan-import-type BetaComputerScrollToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerScrollToolUseBlock
 * @phpstan-import-type BetaComputerWaitToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerWaitToolUseBlock
 * @phpstan-import-type BetaComputerScreenshotToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerScreenshotToolUseBlock
 * @phpstan-import-type BetaComputerZoomToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerZoomToolUseBlock
 *
 * @phpstan-type BetaComputerToolUseBlockVariants = BetaComputerKeyToolUseBlock|BetaComputerHoldKeyToolUseBlock|BetaComputerTypeToolUseBlock|BetaComputerCursorPositionToolUseBlock|BetaComputerMouseMoveToolUseBlock|BetaComputerLeftMouseDownToolUseBlock|BetaComputerLeftMouseUpToolUseBlock|BetaComputerLeftClickToolUseBlock|BetaComputerLeftClickDragToolUseBlock|BetaComputerRightClickToolUseBlock|BetaComputerMiddleClickToolUseBlock|BetaComputerDoubleClickToolUseBlock|BetaComputerTripleClickToolUseBlock|BetaComputerScrollToolUseBlock|BetaComputerWaitToolUseBlock|BetaComputerScreenshotToolUseBlock|BetaComputerZoomToolUseBlock
 * @phpstan-type BetaComputerToolUseBlockShape = BetaComputerToolUseBlockVariants|BetaComputerKeyToolUseBlockShape|BetaComputerHoldKeyToolUseBlockShape|BetaComputerTypeToolUseBlockShape|BetaComputerCursorPositionToolUseBlockShape|BetaComputerMouseMoveToolUseBlockShape|BetaComputerLeftMouseDownToolUseBlockShape|BetaComputerLeftMouseUpToolUseBlockShape|BetaComputerLeftClickToolUseBlockShape|BetaComputerLeftClickDragToolUseBlockShape|BetaComputerRightClickToolUseBlockShape|BetaComputerMiddleClickToolUseBlockShape|BetaComputerDoubleClickToolUseBlockShape|BetaComputerTripleClickToolUseBlockShape|BetaComputerScrollToolUseBlockShape|BetaComputerWaitToolUseBlockShape|BetaComputerScreenshotToolUseBlockShape|BetaComputerZoomToolUseBlockShape
 */
final class BetaComputerToolUseBlock implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'name';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'key' => BetaComputerKeyToolUseBlock::class,
            'hold_key' => BetaComputerHoldKeyToolUseBlock::class,
            'type' => BetaComputerTypeToolUseBlock::class,
            'cursor_position' => BetaComputerCursorPositionToolUseBlock::class,
            'mouse_move' => BetaComputerMouseMoveToolUseBlock::class,
            'left_mouse_down' => BetaComputerLeftMouseDownToolUseBlock::class,
            'left_mouse_up' => BetaComputerLeftMouseUpToolUseBlock::class,
            'left_click' => BetaComputerLeftClickToolUseBlock::class,
            'left_click_drag' => BetaComputerLeftClickDragToolUseBlock::class,
            'right_click' => BetaComputerRightClickToolUseBlock::class,
            'middle_click' => BetaComputerMiddleClickToolUseBlock::class,
            'double_click' => BetaComputerDoubleClickToolUseBlock::class,
            'triple_click' => BetaComputerTripleClickToolUseBlock::class,
            'scroll' => BetaComputerScrollToolUseBlock::class,
            'wait' => BetaComputerWaitToolUseBlock::class,
            'screenshot' => BetaComputerScreenshotToolUseBlock::class,
            'zoom' => BetaComputerZoomToolUseBlock::class,
        ];
    }
}
