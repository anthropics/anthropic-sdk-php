<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBrowserToolUseBlockShape from \Anthropic\Beta\Messages\BetaBrowserToolUseBlock
 * @phpstan-import-type BetaComputerToolUseBlockShape from \Anthropic\Beta\Messages\BetaComputerToolUseBlock
 * @phpstan-import-type BetaToolUseBlockShape from \Anthropic\Beta\Messages\BetaToolUseBlock
 *
 * @phpstan-type BetaToolsetToolUseBlockVariants = BetaBrowserNavigateToolUseBlock|BetaBrowserListTabsToolUseBlock|BetaBrowserNewTabToolUseBlock|BetaBrowserSwitchTabToolUseBlock|BetaBrowserCloseTabToolUseBlock|BetaBrowserReadPageToolUseBlock|BetaBrowserGetPageTextToolUseBlock|BetaBrowserReadConsoleToolUseBlock|BetaBrowserReadNetworkToolUseBlock|BetaBrowserFindToolUseBlock|BetaBrowserFormInputToolUseBlock|BetaBrowserFileUploadToolUseBlock|BetaBrowserScrollToToolUseBlock|BetaBrowserScreenshotToolUseBlock|BetaBrowserZoomToolUseBlock|BetaBrowserLeftClickToolUseBlock|BetaBrowserRightClickToolUseBlock|BetaBrowserMiddleClickToolUseBlock|BetaBrowserDoubleClickToolUseBlock|BetaBrowserTripleClickToolUseBlock|BetaBrowserHoverToolUseBlock|BetaBrowserLeftClickDragToolUseBlock|BetaBrowserLeftMouseDownToolUseBlock|BetaBrowserLeftMouseUpToolUseBlock|BetaBrowserMouseMoveToolUseBlock|BetaBrowserScrollToolUseBlock|BetaBrowserTypeToolUseBlock|BetaBrowserKeyToolUseBlock|BetaBrowserHoldKeyToolUseBlock|BetaBrowserWaitToolUseBlock|BetaBrowserJavascriptExecToolUseBlock|BetaComputerKeyToolUseBlock|BetaComputerHoldKeyToolUseBlock|BetaComputerTypeToolUseBlock|BetaComputerCursorPositionToolUseBlock|BetaComputerMouseMoveToolUseBlock|BetaComputerLeftMouseDownToolUseBlock|BetaComputerLeftMouseUpToolUseBlock|BetaComputerLeftClickToolUseBlock|BetaComputerLeftClickDragToolUseBlock|BetaComputerRightClickToolUseBlock|BetaComputerMiddleClickToolUseBlock|BetaComputerDoubleClickToolUseBlock|BetaComputerTripleClickToolUseBlock|BetaComputerScrollToolUseBlock|BetaComputerWaitToolUseBlock|BetaComputerScreenshotToolUseBlock|BetaComputerZoomToolUseBlock|BetaToolUseBlock
 * @phpstan-type BetaToolsetToolUseBlockShape = BetaToolsetToolUseBlockVariants|BetaBrowserToolUseBlockShape|BetaComputerToolUseBlockShape|BetaToolUseBlockShape
 */
final class BetaToolsetToolUseBlock implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaBrowserToolUseBlock::class,
            BetaComputerToolUseBlock::class,
            BetaToolUseBlock::class,
        ];
    }
}
