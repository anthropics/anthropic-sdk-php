<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BrowserToolUseBlockShape from \Anthropic\Messages\BrowserToolUseBlock
 * @phpstan-import-type ComputerToolUseBlockShape from \Anthropic\Messages\ComputerToolUseBlock
 * @phpstan-import-type ToolUseBlockShape from \Anthropic\Messages\ToolUseBlock
 *
 * @phpstan-type ToolsetToolUseBlockVariants = BrowserNavigateToolUseBlock|BrowserListTabsToolUseBlock|BrowserNewTabToolUseBlock|BrowserSwitchTabToolUseBlock|BrowserCloseTabToolUseBlock|BrowserReadPageToolUseBlock|BrowserGetPageTextToolUseBlock|BrowserReadConsoleToolUseBlock|BrowserReadNetworkToolUseBlock|BrowserFindToolUseBlock|BrowserFormInputToolUseBlock|BrowserFileUploadToolUseBlock|BrowserScrollToToolUseBlock|BrowserScreenshotToolUseBlock|BrowserZoomToolUseBlock|BrowserLeftClickToolUseBlock|BrowserRightClickToolUseBlock|BrowserMiddleClickToolUseBlock|BrowserDoubleClickToolUseBlock|BrowserTripleClickToolUseBlock|BrowserHoverToolUseBlock|BrowserLeftClickDragToolUseBlock|BrowserLeftMouseDownToolUseBlock|BrowserLeftMouseUpToolUseBlock|BrowserMouseMoveToolUseBlock|BrowserScrollToolUseBlock|BrowserTypeToolUseBlock|BrowserKeyToolUseBlock|BrowserHoldKeyToolUseBlock|BrowserWaitToolUseBlock|BrowserJavascriptExecToolUseBlock|ComputerKeyToolUseBlock|ComputerHoldKeyToolUseBlock|ComputerTypeToolUseBlock|ComputerCursorPositionToolUseBlock|ComputerMouseMoveToolUseBlock|ComputerLeftMouseDownToolUseBlock|ComputerLeftMouseUpToolUseBlock|ComputerLeftClickToolUseBlock|ComputerLeftClickDragToolUseBlock|ComputerRightClickToolUseBlock|ComputerMiddleClickToolUseBlock|ComputerDoubleClickToolUseBlock|ComputerTripleClickToolUseBlock|ComputerScrollToolUseBlock|ComputerWaitToolUseBlock|ComputerScreenshotToolUseBlock|ComputerZoomToolUseBlock|ToolUseBlock
 * @phpstan-type ToolsetToolUseBlockShape = ToolsetToolUseBlockVariants|BrowserToolUseBlockShape|ComputerToolUseBlockShape|ToolUseBlockShape
 */
final class ToolsetToolUseBlock implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BrowserToolUseBlock::class,
            ComputerToolUseBlock::class,
            ToolUseBlock::class,
        ];
    }
}
