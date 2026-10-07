<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BrowserNavigateToolUseBlockShape from \Anthropic\Messages\BrowserNavigateToolUseBlock
 * @phpstan-import-type BrowserListTabsToolUseBlockShape from \Anthropic\Messages\BrowserListTabsToolUseBlock
 * @phpstan-import-type BrowserNewTabToolUseBlockShape from \Anthropic\Messages\BrowserNewTabToolUseBlock
 * @phpstan-import-type BrowserSwitchTabToolUseBlockShape from \Anthropic\Messages\BrowserSwitchTabToolUseBlock
 * @phpstan-import-type BrowserCloseTabToolUseBlockShape from \Anthropic\Messages\BrowserCloseTabToolUseBlock
 * @phpstan-import-type BrowserReadPageToolUseBlockShape from \Anthropic\Messages\BrowserReadPageToolUseBlock
 * @phpstan-import-type BrowserGetPageTextToolUseBlockShape from \Anthropic\Messages\BrowserGetPageTextToolUseBlock
 * @phpstan-import-type BrowserReadConsoleToolUseBlockShape from \Anthropic\Messages\BrowserReadConsoleToolUseBlock
 * @phpstan-import-type BrowserReadNetworkToolUseBlockShape from \Anthropic\Messages\BrowserReadNetworkToolUseBlock
 * @phpstan-import-type BrowserFindToolUseBlockShape from \Anthropic\Messages\BrowserFindToolUseBlock
 * @phpstan-import-type BrowserFormInputToolUseBlockShape from \Anthropic\Messages\BrowserFormInputToolUseBlock
 * @phpstan-import-type BrowserFileUploadToolUseBlockShape from \Anthropic\Messages\BrowserFileUploadToolUseBlock
 * @phpstan-import-type BrowserScrollToToolUseBlockShape from \Anthropic\Messages\BrowserScrollToToolUseBlock
 * @phpstan-import-type BrowserScreenshotToolUseBlockShape from \Anthropic\Messages\BrowserScreenshotToolUseBlock
 * @phpstan-import-type BrowserZoomToolUseBlockShape from \Anthropic\Messages\BrowserZoomToolUseBlock
 * @phpstan-import-type BrowserLeftClickToolUseBlockShape from \Anthropic\Messages\BrowserLeftClickToolUseBlock
 * @phpstan-import-type BrowserRightClickToolUseBlockShape from \Anthropic\Messages\BrowserRightClickToolUseBlock
 * @phpstan-import-type BrowserMiddleClickToolUseBlockShape from \Anthropic\Messages\BrowserMiddleClickToolUseBlock
 * @phpstan-import-type BrowserDoubleClickToolUseBlockShape from \Anthropic\Messages\BrowserDoubleClickToolUseBlock
 * @phpstan-import-type BrowserTripleClickToolUseBlockShape from \Anthropic\Messages\BrowserTripleClickToolUseBlock
 * @phpstan-import-type BrowserHoverToolUseBlockShape from \Anthropic\Messages\BrowserHoverToolUseBlock
 * @phpstan-import-type BrowserLeftClickDragToolUseBlockShape from \Anthropic\Messages\BrowserLeftClickDragToolUseBlock
 * @phpstan-import-type BrowserLeftMouseDownToolUseBlockShape from \Anthropic\Messages\BrowserLeftMouseDownToolUseBlock
 * @phpstan-import-type BrowserLeftMouseUpToolUseBlockShape from \Anthropic\Messages\BrowserLeftMouseUpToolUseBlock
 * @phpstan-import-type BrowserMouseMoveToolUseBlockShape from \Anthropic\Messages\BrowserMouseMoveToolUseBlock
 * @phpstan-import-type BrowserScrollToolUseBlockShape from \Anthropic\Messages\BrowserScrollToolUseBlock
 * @phpstan-import-type BrowserTypeToolUseBlockShape from \Anthropic\Messages\BrowserTypeToolUseBlock
 * @phpstan-import-type BrowserKeyToolUseBlockShape from \Anthropic\Messages\BrowserKeyToolUseBlock
 * @phpstan-import-type BrowserHoldKeyToolUseBlockShape from \Anthropic\Messages\BrowserHoldKeyToolUseBlock
 * @phpstan-import-type BrowserWaitToolUseBlockShape from \Anthropic\Messages\BrowserWaitToolUseBlock
 * @phpstan-import-type BrowserJavascriptExecToolUseBlockShape from \Anthropic\Messages\BrowserJavascriptExecToolUseBlock
 *
 * @phpstan-type BrowserToolUseBlockVariants = BrowserNavigateToolUseBlock|BrowserListTabsToolUseBlock|BrowserNewTabToolUseBlock|BrowserSwitchTabToolUseBlock|BrowserCloseTabToolUseBlock|BrowserReadPageToolUseBlock|BrowserGetPageTextToolUseBlock|BrowserReadConsoleToolUseBlock|BrowserReadNetworkToolUseBlock|BrowserFindToolUseBlock|BrowserFormInputToolUseBlock|BrowserFileUploadToolUseBlock|BrowserScrollToToolUseBlock|BrowserScreenshotToolUseBlock|BrowserZoomToolUseBlock|BrowserLeftClickToolUseBlock|BrowserRightClickToolUseBlock|BrowserMiddleClickToolUseBlock|BrowserDoubleClickToolUseBlock|BrowserTripleClickToolUseBlock|BrowserHoverToolUseBlock|BrowserLeftClickDragToolUseBlock|BrowserLeftMouseDownToolUseBlock|BrowserLeftMouseUpToolUseBlock|BrowserMouseMoveToolUseBlock|BrowserScrollToolUseBlock|BrowserTypeToolUseBlock|BrowserKeyToolUseBlock|BrowserHoldKeyToolUseBlock|BrowserWaitToolUseBlock|BrowserJavascriptExecToolUseBlock
 * @phpstan-type BrowserToolUseBlockShape = BrowserToolUseBlockVariants|BrowserNavigateToolUseBlockShape|BrowserListTabsToolUseBlockShape|BrowserNewTabToolUseBlockShape|BrowserSwitchTabToolUseBlockShape|BrowserCloseTabToolUseBlockShape|BrowserReadPageToolUseBlockShape|BrowserGetPageTextToolUseBlockShape|BrowserReadConsoleToolUseBlockShape|BrowserReadNetworkToolUseBlockShape|BrowserFindToolUseBlockShape|BrowserFormInputToolUseBlockShape|BrowserFileUploadToolUseBlockShape|BrowserScrollToToolUseBlockShape|BrowserScreenshotToolUseBlockShape|BrowserZoomToolUseBlockShape|BrowserLeftClickToolUseBlockShape|BrowserRightClickToolUseBlockShape|BrowserMiddleClickToolUseBlockShape|BrowserDoubleClickToolUseBlockShape|BrowserTripleClickToolUseBlockShape|BrowserHoverToolUseBlockShape|BrowserLeftClickDragToolUseBlockShape|BrowserLeftMouseDownToolUseBlockShape|BrowserLeftMouseUpToolUseBlockShape|BrowserMouseMoveToolUseBlockShape|BrowserScrollToolUseBlockShape|BrowserTypeToolUseBlockShape|BrowserKeyToolUseBlockShape|BrowserHoldKeyToolUseBlockShape|BrowserWaitToolUseBlockShape|BrowserJavascriptExecToolUseBlockShape
 */
final class BrowserToolUseBlock implements ConverterSource
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
            'navigate' => BrowserNavigateToolUseBlock::class,
            'list_tabs' => BrowserListTabsToolUseBlock::class,
            'new_tab' => BrowserNewTabToolUseBlock::class,
            'switch_tab' => BrowserSwitchTabToolUseBlock::class,
            'close_tab' => BrowserCloseTabToolUseBlock::class,
            'read_page' => BrowserReadPageToolUseBlock::class,
            'get_page_text' => BrowserGetPageTextToolUseBlock::class,
            'read_console' => BrowserReadConsoleToolUseBlock::class,
            'read_network' => BrowserReadNetworkToolUseBlock::class,
            'find' => BrowserFindToolUseBlock::class,
            'form_input' => BrowserFormInputToolUseBlock::class,
            'file_upload' => BrowserFileUploadToolUseBlock::class,
            'scroll_to' => BrowserScrollToToolUseBlock::class,
            'screenshot' => BrowserScreenshotToolUseBlock::class,
            'zoom' => BrowserZoomToolUseBlock::class,
            'left_click' => BrowserLeftClickToolUseBlock::class,
            'right_click' => BrowserRightClickToolUseBlock::class,
            'middle_click' => BrowserMiddleClickToolUseBlock::class,
            'double_click' => BrowserDoubleClickToolUseBlock::class,
            'triple_click' => BrowserTripleClickToolUseBlock::class,
            'hover' => BrowserHoverToolUseBlock::class,
            'left_click_drag' => BrowserLeftClickDragToolUseBlock::class,
            'left_mouse_down' => BrowserLeftMouseDownToolUseBlock::class,
            'left_mouse_up' => BrowserLeftMouseUpToolUseBlock::class,
            'mouse_move' => BrowserMouseMoveToolUseBlock::class,
            'scroll' => BrowserScrollToolUseBlock::class,
            'type' => BrowserTypeToolUseBlock::class,
            'key' => BrowserKeyToolUseBlock::class,
            'hold_key' => BrowserHoldKeyToolUseBlock::class,
            'wait' => BrowserWaitToolUseBlock::class,
            'javascript_exec' => BrowserJavascriptExecToolUseBlock::class,
        ];
    }
}
