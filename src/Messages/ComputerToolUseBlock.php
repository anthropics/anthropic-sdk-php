<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ComputerKeyToolUseBlockShape from \Anthropic\Messages\ComputerKeyToolUseBlock
 * @phpstan-import-type ComputerHoldKeyToolUseBlockShape from \Anthropic\Messages\ComputerHoldKeyToolUseBlock
 * @phpstan-import-type ComputerTypeToolUseBlockShape from \Anthropic\Messages\ComputerTypeToolUseBlock
 * @phpstan-import-type ComputerCursorPositionToolUseBlockShape from \Anthropic\Messages\ComputerCursorPositionToolUseBlock
 * @phpstan-import-type ComputerMouseMoveToolUseBlockShape from \Anthropic\Messages\ComputerMouseMoveToolUseBlock
 * @phpstan-import-type ComputerLeftMouseDownToolUseBlockShape from \Anthropic\Messages\ComputerLeftMouseDownToolUseBlock
 * @phpstan-import-type ComputerLeftMouseUpToolUseBlockShape from \Anthropic\Messages\ComputerLeftMouseUpToolUseBlock
 * @phpstan-import-type ComputerLeftClickToolUseBlockShape from \Anthropic\Messages\ComputerLeftClickToolUseBlock
 * @phpstan-import-type ComputerLeftClickDragToolUseBlockShape from \Anthropic\Messages\ComputerLeftClickDragToolUseBlock
 * @phpstan-import-type ComputerRightClickToolUseBlockShape from \Anthropic\Messages\ComputerRightClickToolUseBlock
 * @phpstan-import-type ComputerMiddleClickToolUseBlockShape from \Anthropic\Messages\ComputerMiddleClickToolUseBlock
 * @phpstan-import-type ComputerDoubleClickToolUseBlockShape from \Anthropic\Messages\ComputerDoubleClickToolUseBlock
 * @phpstan-import-type ComputerTripleClickToolUseBlockShape from \Anthropic\Messages\ComputerTripleClickToolUseBlock
 * @phpstan-import-type ComputerScrollToolUseBlockShape from \Anthropic\Messages\ComputerScrollToolUseBlock
 * @phpstan-import-type ComputerWaitToolUseBlockShape from \Anthropic\Messages\ComputerWaitToolUseBlock
 * @phpstan-import-type ComputerScreenshotToolUseBlockShape from \Anthropic\Messages\ComputerScreenshotToolUseBlock
 * @phpstan-import-type ComputerZoomToolUseBlockShape from \Anthropic\Messages\ComputerZoomToolUseBlock
 *
 * @phpstan-type ComputerToolUseBlockVariants = ComputerKeyToolUseBlock|ComputerHoldKeyToolUseBlock|ComputerTypeToolUseBlock|ComputerCursorPositionToolUseBlock|ComputerMouseMoveToolUseBlock|ComputerLeftMouseDownToolUseBlock|ComputerLeftMouseUpToolUseBlock|ComputerLeftClickToolUseBlock|ComputerLeftClickDragToolUseBlock|ComputerRightClickToolUseBlock|ComputerMiddleClickToolUseBlock|ComputerDoubleClickToolUseBlock|ComputerTripleClickToolUseBlock|ComputerScrollToolUseBlock|ComputerWaitToolUseBlock|ComputerScreenshotToolUseBlock|ComputerZoomToolUseBlock
 * @phpstan-type ComputerToolUseBlockShape = ComputerToolUseBlockVariants|ComputerKeyToolUseBlockShape|ComputerHoldKeyToolUseBlockShape|ComputerTypeToolUseBlockShape|ComputerCursorPositionToolUseBlockShape|ComputerMouseMoveToolUseBlockShape|ComputerLeftMouseDownToolUseBlockShape|ComputerLeftMouseUpToolUseBlockShape|ComputerLeftClickToolUseBlockShape|ComputerLeftClickDragToolUseBlockShape|ComputerRightClickToolUseBlockShape|ComputerMiddleClickToolUseBlockShape|ComputerDoubleClickToolUseBlockShape|ComputerTripleClickToolUseBlockShape|ComputerScrollToolUseBlockShape|ComputerWaitToolUseBlockShape|ComputerScreenshotToolUseBlockShape|ComputerZoomToolUseBlockShape
 */
final class ComputerToolUseBlock implements ConverterSource
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
            'key' => ComputerKeyToolUseBlock::class,
            'hold_key' => ComputerHoldKeyToolUseBlock::class,
            'type' => ComputerTypeToolUseBlock::class,
            'cursor_position' => ComputerCursorPositionToolUseBlock::class,
            'mouse_move' => ComputerMouseMoveToolUseBlock::class,
            'left_mouse_down' => ComputerLeftMouseDownToolUseBlock::class,
            'left_mouse_up' => ComputerLeftMouseUpToolUseBlock::class,
            'left_click' => ComputerLeftClickToolUseBlock::class,
            'left_click_drag' => ComputerLeftClickDragToolUseBlock::class,
            'right_click' => ComputerRightClickToolUseBlock::class,
            'middle_click' => ComputerMiddleClickToolUseBlock::class,
            'double_click' => ComputerDoubleClickToolUseBlock::class,
            'triple_click' => ComputerTripleClickToolUseBlock::class,
            'scroll' => ComputerScrollToolUseBlock::class,
            'wait' => ComputerWaitToolUseBlock::class,
            'screenshot' => ComputerScreenshotToolUseBlock::class,
            'zoom' => ComputerZoomToolUseBlock::class,
        ];
    }
}
