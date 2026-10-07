<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBrowserNavigateToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserNavigateToolUseBlock
 * @phpstan-import-type BetaBrowserListTabsToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserListTabsToolUseBlock
 * @phpstan-import-type BetaBrowserNewTabToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserNewTabToolUseBlock
 * @phpstan-import-type BetaBrowserSwitchTabToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserSwitchTabToolUseBlock
 * @phpstan-import-type BetaBrowserCloseTabToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserCloseTabToolUseBlock
 * @phpstan-import-type BetaBrowserReadPageToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserReadPageToolUseBlock
 * @phpstan-import-type BetaBrowserGetPageTextToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserGetPageTextToolUseBlock
 * @phpstan-import-type BetaBrowserReadConsoleToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserReadConsoleToolUseBlock
 * @phpstan-import-type BetaBrowserReadNetworkToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserReadNetworkToolUseBlock
 * @phpstan-import-type BetaBrowserFindToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserFindToolUseBlock
 * @phpstan-import-type BetaBrowserFormInputToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserFormInputToolUseBlock
 * @phpstan-import-type BetaBrowserFileUploadToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserFileUploadToolUseBlock
 * @phpstan-import-type BetaBrowserScrollToToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserScrollToToolUseBlock
 * @phpstan-import-type BetaBrowserScreenshotToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserScreenshotToolUseBlock
 * @phpstan-import-type BetaBrowserZoomToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserZoomToolUseBlock
 * @phpstan-import-type BetaBrowserLeftClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserLeftClickToolUseBlock
 * @phpstan-import-type BetaBrowserRightClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserRightClickToolUseBlock
 * @phpstan-import-type BetaBrowserMiddleClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserMiddleClickToolUseBlock
 * @phpstan-import-type BetaBrowserDoubleClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserDoubleClickToolUseBlock
 * @phpstan-import-type BetaBrowserTripleClickToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserTripleClickToolUseBlock
 * @phpstan-import-type BetaBrowserHoverToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserHoverToolUseBlock
 * @phpstan-import-type BetaBrowserLeftClickDragToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserLeftClickDragToolUseBlock
 * @phpstan-import-type BetaBrowserLeftMouseDownToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserLeftMouseDownToolUseBlock
 * @phpstan-import-type BetaBrowserLeftMouseUpToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserLeftMouseUpToolUseBlock
 * @phpstan-import-type BetaBrowserMouseMoveToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserMouseMoveToolUseBlock
 * @phpstan-import-type BetaBrowserScrollToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserScrollToolUseBlock
 * @phpstan-import-type BetaBrowserTypeToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserTypeToolUseBlock
 * @phpstan-import-type BetaBrowserKeyToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserKeyToolUseBlock
 * @phpstan-import-type BetaBrowserHoldKeyToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserHoldKeyToolUseBlock
 * @phpstan-import-type BetaBrowserWaitToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserWaitToolUseBlock
 * @phpstan-import-type BetaBrowserJavascriptExecToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserJavascriptExecToolUseBlock
 *
 * @phpstan-type BetaBrowserToolUseBlockVariants = BetaBrowserNavigateToolUseBlock|BetaBrowserListTabsToolUseBlock|BetaBrowserNewTabToolUseBlock|BetaBrowserSwitchTabToolUseBlock|BetaBrowserCloseTabToolUseBlock|BetaBrowserReadPageToolUseBlock|BetaBrowserGetPageTextToolUseBlock|BetaBrowserReadConsoleToolUseBlock|BetaBrowserReadNetworkToolUseBlock|BetaBrowserFindToolUseBlock|BetaBrowserFormInputToolUseBlock|BetaBrowserFileUploadToolUseBlock|BetaBrowserScrollToToolUseBlock|BetaBrowserScreenshotToolUseBlock|BetaBrowserZoomToolUseBlock|BetaBrowserLeftClickToolUseBlock|BetaBrowserRightClickToolUseBlock|BetaBrowserMiddleClickToolUseBlock|BetaBrowserDoubleClickToolUseBlock|BetaBrowserTripleClickToolUseBlock|BetaBrowserHoverToolUseBlock|BetaBrowserLeftClickDragToolUseBlock|BetaBrowserLeftMouseDownToolUseBlock|BetaBrowserLeftMouseUpToolUseBlock|BetaBrowserMouseMoveToolUseBlock|BetaBrowserScrollToolUseBlock|BetaBrowserTypeToolUseBlock|BetaBrowserKeyToolUseBlock|BetaBrowserHoldKeyToolUseBlock|BetaBrowserWaitToolUseBlock|BetaBrowserJavascriptExecToolUseBlock
 * @phpstan-type BetaBrowserToolUseBlockShape = BetaBrowserToolUseBlockVariants|BetaBrowserNavigateToolUseBlockShape|BetaBrowserListTabsToolUseBlockShape|BetaBrowserNewTabToolUseBlockShape|BetaBrowserSwitchTabToolUseBlockShape|BetaBrowserCloseTabToolUseBlockShape|BetaBrowserReadPageToolUseBlockShape|BetaBrowserGetPageTextToolUseBlockShape|BetaBrowserReadConsoleToolUseBlockShape|BetaBrowserReadNetworkToolUseBlockShape|BetaBrowserFindToolUseBlockShape|BetaBrowserFormInputToolUseBlockShape|BetaBrowserFileUploadToolUseBlockShape|BetaBrowserScrollToToolUseBlockShape|BetaBrowserScreenshotToolUseBlockShape|BetaBrowserZoomToolUseBlockShape|BetaBrowserLeftClickToolUseBlockShape|BetaBrowserRightClickToolUseBlockShape|BetaBrowserMiddleClickToolUseBlockShape|BetaBrowserDoubleClickToolUseBlockShape|BetaBrowserTripleClickToolUseBlockShape|BetaBrowserHoverToolUseBlockShape|BetaBrowserLeftClickDragToolUseBlockShape|BetaBrowserLeftMouseDownToolUseBlockShape|BetaBrowserLeftMouseUpToolUseBlockShape|BetaBrowserMouseMoveToolUseBlockShape|BetaBrowserScrollToolUseBlockShape|BetaBrowserTypeToolUseBlockShape|BetaBrowserKeyToolUseBlockShape|BetaBrowserHoldKeyToolUseBlockShape|BetaBrowserWaitToolUseBlockShape|BetaBrowserJavascriptExecToolUseBlockShape
 */
final class BetaBrowserToolUseBlock implements ConverterSource
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
            'navigate' => BetaBrowserNavigateToolUseBlock::class,
            'list_tabs' => BetaBrowserListTabsToolUseBlock::class,
            'new_tab' => BetaBrowserNewTabToolUseBlock::class,
            'switch_tab' => BetaBrowserSwitchTabToolUseBlock::class,
            'close_tab' => BetaBrowserCloseTabToolUseBlock::class,
            'read_page' => BetaBrowserReadPageToolUseBlock::class,
            'get_page_text' => BetaBrowserGetPageTextToolUseBlock::class,
            'read_console' => BetaBrowserReadConsoleToolUseBlock::class,
            'read_network' => BetaBrowserReadNetworkToolUseBlock::class,
            'find' => BetaBrowserFindToolUseBlock::class,
            'form_input' => BetaBrowserFormInputToolUseBlock::class,
            'file_upload' => BetaBrowserFileUploadToolUseBlock::class,
            'scroll_to' => BetaBrowserScrollToToolUseBlock::class,
            'screenshot' => BetaBrowserScreenshotToolUseBlock::class,
            'zoom' => BetaBrowserZoomToolUseBlock::class,
            'left_click' => BetaBrowserLeftClickToolUseBlock::class,
            'right_click' => BetaBrowserRightClickToolUseBlock::class,
            'middle_click' => BetaBrowserMiddleClickToolUseBlock::class,
            'double_click' => BetaBrowserDoubleClickToolUseBlock::class,
            'triple_click' => BetaBrowserTripleClickToolUseBlock::class,
            'hover' => BetaBrowserHoverToolUseBlock::class,
            'left_click_drag' => BetaBrowserLeftClickDragToolUseBlock::class,
            'left_mouse_down' => BetaBrowserLeftMouseDownToolUseBlock::class,
            'left_mouse_up' => BetaBrowserLeftMouseUpToolUseBlock::class,
            'mouse_move' => BetaBrowserMouseMoveToolUseBlock::class,
            'scroll' => BetaBrowserScrollToolUseBlock::class,
            'type' => BetaBrowserTypeToolUseBlock::class,
            'key' => BetaBrowserKeyToolUseBlock::class,
            'hold_key' => BetaBrowserHoldKeyToolUseBlock::class,
            'wait' => BetaBrowserWaitToolUseBlock::class,
            'javascript_exec' => BetaBrowserJavascriptExecToolUseBlock::class,
        ];
    }
}
