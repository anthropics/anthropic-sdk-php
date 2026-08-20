<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-member configuration for ``browser_toolset_20260801``: one
 * optional field per member tool, keyed by the member name — the same
 * name the member's ``tool_use`` blocks carry. Every member is an
 * accepted key, and a member's defaults apply wherever its key is
 * absent. Unknown keys are rejected: the field set is this toolset
 * version's complete member set.
 *
 * @phpstan-import-type BetaBrowserCloseTabConfigShape from \Anthropic\Beta\Messages\BetaBrowserCloseTabConfig
 * @phpstan-import-type BetaBrowserDoubleClickConfigShape from \Anthropic\Beta\Messages\BetaBrowserDoubleClickConfig
 * @phpstan-import-type BetaBrowserFileUploadConfigShape from \Anthropic\Beta\Messages\BetaBrowserFileUploadConfig
 * @phpstan-import-type BetaBrowserFindConfigShape from \Anthropic\Beta\Messages\BetaBrowserFindConfig
 * @phpstan-import-type BetaBrowserFormInputConfigShape from \Anthropic\Beta\Messages\BetaBrowserFormInputConfig
 * @phpstan-import-type BetaBrowserGetPageTextConfigShape from \Anthropic\Beta\Messages\BetaBrowserGetPageTextConfig
 * @phpstan-import-type BetaBrowserHoldKeyConfigShape from \Anthropic\Beta\Messages\BetaBrowserHoldKeyConfig
 * @phpstan-import-type BetaBrowserHoverConfigShape from \Anthropic\Beta\Messages\BetaBrowserHoverConfig
 * @phpstan-import-type BetaBrowserJavascriptExecConfigShape from \Anthropic\Beta\Messages\BetaBrowserJavascriptExecConfig
 * @phpstan-import-type BetaBrowserKeyConfigShape from \Anthropic\Beta\Messages\BetaBrowserKeyConfig
 * @phpstan-import-type BetaBrowserLeftClickConfigShape from \Anthropic\Beta\Messages\BetaBrowserLeftClickConfig
 * @phpstan-import-type BetaBrowserLeftClickDragConfigShape from \Anthropic\Beta\Messages\BetaBrowserLeftClickDragConfig
 * @phpstan-import-type BetaBrowserLeftMouseDownConfigShape from \Anthropic\Beta\Messages\BetaBrowserLeftMouseDownConfig
 * @phpstan-import-type BetaBrowserLeftMouseUpConfigShape from \Anthropic\Beta\Messages\BetaBrowserLeftMouseUpConfig
 * @phpstan-import-type BetaBrowserListTabsConfigShape from \Anthropic\Beta\Messages\BetaBrowserListTabsConfig
 * @phpstan-import-type BetaBrowserMiddleClickConfigShape from \Anthropic\Beta\Messages\BetaBrowserMiddleClickConfig
 * @phpstan-import-type BetaBrowserMouseMoveConfigShape from \Anthropic\Beta\Messages\BetaBrowserMouseMoveConfig
 * @phpstan-import-type BetaBrowserNavigateConfigShape from \Anthropic\Beta\Messages\BetaBrowserNavigateConfig
 * @phpstan-import-type BetaBrowserNewTabConfigShape from \Anthropic\Beta\Messages\BetaBrowserNewTabConfig
 * @phpstan-import-type BetaBrowserReadConsoleConfigShape from \Anthropic\Beta\Messages\BetaBrowserReadConsoleConfig
 * @phpstan-import-type BetaBrowserReadNetworkConfigShape from \Anthropic\Beta\Messages\BetaBrowserReadNetworkConfig
 * @phpstan-import-type BetaBrowserReadPageConfigShape from \Anthropic\Beta\Messages\BetaBrowserReadPageConfig
 * @phpstan-import-type BetaBrowserRightClickConfigShape from \Anthropic\Beta\Messages\BetaBrowserRightClickConfig
 * @phpstan-import-type BetaBrowserScreenshotConfigShape from \Anthropic\Beta\Messages\BetaBrowserScreenshotConfig
 * @phpstan-import-type BetaBrowserScrollConfigShape from \Anthropic\Beta\Messages\BetaBrowserScrollConfig
 * @phpstan-import-type BetaBrowserScrollToConfigShape from \Anthropic\Beta\Messages\BetaBrowserScrollToConfig
 * @phpstan-import-type BetaBrowserSwitchTabConfigShape from \Anthropic\Beta\Messages\BetaBrowserSwitchTabConfig
 * @phpstan-import-type BetaBrowserTripleClickConfigShape from \Anthropic\Beta\Messages\BetaBrowserTripleClickConfig
 * @phpstan-import-type BetaBrowserTypeConfigShape from \Anthropic\Beta\Messages\BetaBrowserTypeConfig
 * @phpstan-import-type BetaBrowserWaitConfigShape from \Anthropic\Beta\Messages\BetaBrowserWaitConfig
 * @phpstan-import-type BetaBrowserZoomConfigShape from \Anthropic\Beta\Messages\BetaBrowserZoomConfig
 *
 * @phpstan-type BetaBrowserToolsetConfigsShape = array{
 *   closeTab?: null|BetaBrowserCloseTabConfig|BetaBrowserCloseTabConfigShape,
 *   doubleClick?: null|BetaBrowserDoubleClickConfig|BetaBrowserDoubleClickConfigShape,
 *   fileUpload?: null|BetaBrowserFileUploadConfig|BetaBrowserFileUploadConfigShape,
 *   find?: null|BetaBrowserFindConfig|BetaBrowserFindConfigShape,
 *   formInput?: null|BetaBrowserFormInputConfig|BetaBrowserFormInputConfigShape,
 *   getPageText?: null|BetaBrowserGetPageTextConfig|BetaBrowserGetPageTextConfigShape,
 *   holdKey?: null|BetaBrowserHoldKeyConfig|BetaBrowserHoldKeyConfigShape,
 *   hover?: null|BetaBrowserHoverConfig|BetaBrowserHoverConfigShape,
 *   javascriptExec?: null|BetaBrowserJavascriptExecConfig|BetaBrowserJavascriptExecConfigShape,
 *   key?: null|BetaBrowserKeyConfig|BetaBrowserKeyConfigShape,
 *   leftClick?: null|BetaBrowserLeftClickConfig|BetaBrowserLeftClickConfigShape,
 *   leftClickDrag?: null|BetaBrowserLeftClickDragConfig|BetaBrowserLeftClickDragConfigShape,
 *   leftMouseDown?: null|BetaBrowserLeftMouseDownConfig|BetaBrowserLeftMouseDownConfigShape,
 *   leftMouseUp?: null|BetaBrowserLeftMouseUpConfig|BetaBrowserLeftMouseUpConfigShape,
 *   listTabs?: null|BetaBrowserListTabsConfig|BetaBrowserListTabsConfigShape,
 *   middleClick?: null|BetaBrowserMiddleClickConfig|BetaBrowserMiddleClickConfigShape,
 *   mouseMove?: null|BetaBrowserMouseMoveConfig|BetaBrowserMouseMoveConfigShape,
 *   navigate?: null|BetaBrowserNavigateConfig|BetaBrowserNavigateConfigShape,
 *   newTab?: null|BetaBrowserNewTabConfig|BetaBrowserNewTabConfigShape,
 *   readConsole?: null|BetaBrowserReadConsoleConfig|BetaBrowserReadConsoleConfigShape,
 *   readNetwork?: null|BetaBrowserReadNetworkConfig|BetaBrowserReadNetworkConfigShape,
 *   readPage?: null|BetaBrowserReadPageConfig|BetaBrowserReadPageConfigShape,
 *   rightClick?: null|BetaBrowserRightClickConfig|BetaBrowserRightClickConfigShape,
 *   screenshot?: null|BetaBrowserScreenshotConfig|BetaBrowserScreenshotConfigShape,
 *   scroll?: null|BetaBrowserScrollConfig|BetaBrowserScrollConfigShape,
 *   scrollTo?: null|BetaBrowserScrollToConfig|BetaBrowserScrollToConfigShape,
 *   switchTab?: null|BetaBrowserSwitchTabConfig|BetaBrowserSwitchTabConfigShape,
 *   tripleClick?: null|BetaBrowserTripleClickConfig|BetaBrowserTripleClickConfigShape,
 *   type?: null|BetaBrowserTypeConfig|BetaBrowserTypeConfigShape,
 *   wait?: null|BetaBrowserWaitConfig|BetaBrowserWaitConfigShape,
 *   zoom?: null|BetaBrowserZoomConfig|BetaBrowserZoomConfigShape,
 * }
 */
final class BetaBrowserToolsetConfigs implements BaseModel
{
    /** @use SdkModel<BetaBrowserToolsetConfigsShape> */
    use SdkModel;

    /**
     * ``close_tab``'s config overrides.
     */
    #[Optional('close_tab', nullable: true)]
    public ?BetaBrowserCloseTabConfig $closeTab;

    /**
     * ``double_click``'s config overrides.
     */
    #[Optional('double_click', nullable: true)]
    public ?BetaBrowserDoubleClickConfig $doubleClick;

    /**
     * ``file_upload``'s config overrides.
     */
    #[Optional('file_upload', nullable: true)]
    public ?BetaBrowserFileUploadConfig $fileUpload;

    /**
     * ``find``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserFindConfig $find;

    /**
     * ``form_input``'s config overrides.
     */
    #[Optional('form_input', nullable: true)]
    public ?BetaBrowserFormInputConfig $formInput;

    /**
     * ``get_page_text``'s config overrides.
     */
    #[Optional('get_page_text', nullable: true)]
    public ?BetaBrowserGetPageTextConfig $getPageText;

    /**
     * ``hold_key``'s config overrides.
     */
    #[Optional('hold_key', nullable: true)]
    public ?BetaBrowserHoldKeyConfig $holdKey;

    /**
     * ``hover``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserHoverConfig $hover;

    /**
     * ``javascript_exec``'s config overrides.
     */
    #[Optional('javascript_exec', nullable: true)]
    public ?BetaBrowserJavascriptExecConfig $javascriptExec;

    /**
     * ``key``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserKeyConfig $key;

    /**
     * ``left_click``'s config overrides.
     */
    #[Optional('left_click', nullable: true)]
    public ?BetaBrowserLeftClickConfig $leftClick;

    /**
     * ``left_click_drag``'s config overrides.
     */
    #[Optional('left_click_drag', nullable: true)]
    public ?BetaBrowserLeftClickDragConfig $leftClickDrag;

    /**
     * ``left_mouse_down``'s config overrides.
     */
    #[Optional('left_mouse_down', nullable: true)]
    public ?BetaBrowserLeftMouseDownConfig $leftMouseDown;

    /**
     * ``left_mouse_up``'s config overrides.
     */
    #[Optional('left_mouse_up', nullable: true)]
    public ?BetaBrowserLeftMouseUpConfig $leftMouseUp;

    /**
     * ``list_tabs``'s config overrides.
     */
    #[Optional('list_tabs', nullable: true)]
    public ?BetaBrowserListTabsConfig $listTabs;

    /**
     * ``middle_click``'s config overrides.
     */
    #[Optional('middle_click', nullable: true)]
    public ?BetaBrowserMiddleClickConfig $middleClick;

    /**
     * ``mouse_move``'s config overrides.
     */
    #[Optional('mouse_move', nullable: true)]
    public ?BetaBrowserMouseMoveConfig $mouseMove;

    /**
     * ``navigate``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserNavigateConfig $navigate;

    /**
     * ``new_tab``'s config overrides.
     */
    #[Optional('new_tab', nullable: true)]
    public ?BetaBrowserNewTabConfig $newTab;

    /**
     * ``read_console``'s config overrides.
     */
    #[Optional('read_console', nullable: true)]
    public ?BetaBrowserReadConsoleConfig $readConsole;

    /**
     * ``read_network``'s config overrides.
     */
    #[Optional('read_network', nullable: true)]
    public ?BetaBrowserReadNetworkConfig $readNetwork;

    /**
     * ``read_page``'s config overrides.
     */
    #[Optional('read_page', nullable: true)]
    public ?BetaBrowserReadPageConfig $readPage;

    /**
     * ``right_click``'s config overrides.
     */
    #[Optional('right_click', nullable: true)]
    public ?BetaBrowserRightClickConfig $rightClick;

    /**
     * ``screenshot``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserScreenshotConfig $screenshot;

    /**
     * ``scroll``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserScrollConfig $scroll;

    /**
     * ``scroll_to``'s config overrides.
     */
    #[Optional('scroll_to', nullable: true)]
    public ?BetaBrowserScrollToConfig $scrollTo;

    /**
     * ``switch_tab``'s config overrides.
     */
    #[Optional('switch_tab', nullable: true)]
    public ?BetaBrowserSwitchTabConfig $switchTab;

    /**
     * ``triple_click``'s config overrides.
     */
    #[Optional('triple_click', nullable: true)]
    public ?BetaBrowserTripleClickConfig $tripleClick;

    /**
     * ``type``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserTypeConfig $type;

    /**
     * ``wait``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserWaitConfig $wait;

    /**
     * ``zoom``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BetaBrowserZoomConfig $zoom;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaBrowserCloseTabConfig|BetaBrowserCloseTabConfigShape|null $closeTab
     * @param BetaBrowserDoubleClickConfig|BetaBrowserDoubleClickConfigShape|null $doubleClick
     * @param BetaBrowserFileUploadConfig|BetaBrowserFileUploadConfigShape|null $fileUpload
     * @param BetaBrowserFindConfig|BetaBrowserFindConfigShape|null $find
     * @param BetaBrowserFormInputConfig|BetaBrowserFormInputConfigShape|null $formInput
     * @param BetaBrowserGetPageTextConfig|BetaBrowserGetPageTextConfigShape|null $getPageText
     * @param BetaBrowserHoldKeyConfig|BetaBrowserHoldKeyConfigShape|null $holdKey
     * @param BetaBrowserHoverConfig|BetaBrowserHoverConfigShape|null $hover
     * @param BetaBrowserJavascriptExecConfig|BetaBrowserJavascriptExecConfigShape|null $javascriptExec
     * @param BetaBrowserKeyConfig|BetaBrowserKeyConfigShape|null $key
     * @param BetaBrowserLeftClickConfig|BetaBrowserLeftClickConfigShape|null $leftClick
     * @param BetaBrowserLeftClickDragConfig|BetaBrowserLeftClickDragConfigShape|null $leftClickDrag
     * @param BetaBrowserLeftMouseDownConfig|BetaBrowserLeftMouseDownConfigShape|null $leftMouseDown
     * @param BetaBrowserLeftMouseUpConfig|BetaBrowserLeftMouseUpConfigShape|null $leftMouseUp
     * @param BetaBrowserListTabsConfig|BetaBrowserListTabsConfigShape|null $listTabs
     * @param BetaBrowserMiddleClickConfig|BetaBrowserMiddleClickConfigShape|null $middleClick
     * @param BetaBrowserMouseMoveConfig|BetaBrowserMouseMoveConfigShape|null $mouseMove
     * @param BetaBrowserNavigateConfig|BetaBrowserNavigateConfigShape|null $navigate
     * @param BetaBrowserNewTabConfig|BetaBrowserNewTabConfigShape|null $newTab
     * @param BetaBrowserReadConsoleConfig|BetaBrowserReadConsoleConfigShape|null $readConsole
     * @param BetaBrowserReadNetworkConfig|BetaBrowserReadNetworkConfigShape|null $readNetwork
     * @param BetaBrowserReadPageConfig|BetaBrowserReadPageConfigShape|null $readPage
     * @param BetaBrowserRightClickConfig|BetaBrowserRightClickConfigShape|null $rightClick
     * @param BetaBrowserScreenshotConfig|BetaBrowserScreenshotConfigShape|null $screenshot
     * @param BetaBrowserScrollConfig|BetaBrowserScrollConfigShape|null $scroll
     * @param BetaBrowserScrollToConfig|BetaBrowserScrollToConfigShape|null $scrollTo
     * @param BetaBrowserSwitchTabConfig|BetaBrowserSwitchTabConfigShape|null $switchTab
     * @param BetaBrowserTripleClickConfig|BetaBrowserTripleClickConfigShape|null $tripleClick
     * @param BetaBrowserTypeConfig|BetaBrowserTypeConfigShape|null $type
     * @param BetaBrowserWaitConfig|BetaBrowserWaitConfigShape|null $wait
     * @param BetaBrowserZoomConfig|BetaBrowserZoomConfigShape|null $zoom
     */
    public static function with(
        BetaBrowserCloseTabConfig|array|null $closeTab = null,
        BetaBrowserDoubleClickConfig|array|null $doubleClick = null,
        BetaBrowserFileUploadConfig|array|null $fileUpload = null,
        BetaBrowserFindConfig|array|null $find = null,
        BetaBrowserFormInputConfig|array|null $formInput = null,
        BetaBrowserGetPageTextConfig|array|null $getPageText = null,
        BetaBrowserHoldKeyConfig|array|null $holdKey = null,
        BetaBrowserHoverConfig|array|null $hover = null,
        BetaBrowserJavascriptExecConfig|array|null $javascriptExec = null,
        BetaBrowserKeyConfig|array|null $key = null,
        BetaBrowserLeftClickConfig|array|null $leftClick = null,
        BetaBrowserLeftClickDragConfig|array|null $leftClickDrag = null,
        BetaBrowserLeftMouseDownConfig|array|null $leftMouseDown = null,
        BetaBrowserLeftMouseUpConfig|array|null $leftMouseUp = null,
        BetaBrowserListTabsConfig|array|null $listTabs = null,
        BetaBrowserMiddleClickConfig|array|null $middleClick = null,
        BetaBrowserMouseMoveConfig|array|null $mouseMove = null,
        BetaBrowserNavigateConfig|array|null $navigate = null,
        BetaBrowserNewTabConfig|array|null $newTab = null,
        BetaBrowserReadConsoleConfig|array|null $readConsole = null,
        BetaBrowserReadNetworkConfig|array|null $readNetwork = null,
        BetaBrowserReadPageConfig|array|null $readPage = null,
        BetaBrowserRightClickConfig|array|null $rightClick = null,
        BetaBrowserScreenshotConfig|array|null $screenshot = null,
        BetaBrowserScrollConfig|array|null $scroll = null,
        BetaBrowserScrollToConfig|array|null $scrollTo = null,
        BetaBrowserSwitchTabConfig|array|null $switchTab = null,
        BetaBrowserTripleClickConfig|array|null $tripleClick = null,
        BetaBrowserTypeConfig|array|null $type = null,
        BetaBrowserWaitConfig|array|null $wait = null,
        BetaBrowserZoomConfig|array|null $zoom = null,
    ): self {
        $self = new self;

        null !== $closeTab && $self['closeTab'] = $closeTab;
        null !== $doubleClick && $self['doubleClick'] = $doubleClick;
        null !== $fileUpload && $self['fileUpload'] = $fileUpload;
        null !== $find && $self['find'] = $find;
        null !== $formInput && $self['formInput'] = $formInput;
        null !== $getPageText && $self['getPageText'] = $getPageText;
        null !== $holdKey && $self['holdKey'] = $holdKey;
        null !== $hover && $self['hover'] = $hover;
        null !== $javascriptExec && $self['javascriptExec'] = $javascriptExec;
        null !== $key && $self['key'] = $key;
        null !== $leftClick && $self['leftClick'] = $leftClick;
        null !== $leftClickDrag && $self['leftClickDrag'] = $leftClickDrag;
        null !== $leftMouseDown && $self['leftMouseDown'] = $leftMouseDown;
        null !== $leftMouseUp && $self['leftMouseUp'] = $leftMouseUp;
        null !== $listTabs && $self['listTabs'] = $listTabs;
        null !== $middleClick && $self['middleClick'] = $middleClick;
        null !== $mouseMove && $self['mouseMove'] = $mouseMove;
        null !== $navigate && $self['navigate'] = $navigate;
        null !== $newTab && $self['newTab'] = $newTab;
        null !== $readConsole && $self['readConsole'] = $readConsole;
        null !== $readNetwork && $self['readNetwork'] = $readNetwork;
        null !== $readPage && $self['readPage'] = $readPage;
        null !== $rightClick && $self['rightClick'] = $rightClick;
        null !== $screenshot && $self['screenshot'] = $screenshot;
        null !== $scroll && $self['scroll'] = $scroll;
        null !== $scrollTo && $self['scrollTo'] = $scrollTo;
        null !== $switchTab && $self['switchTab'] = $switchTab;
        null !== $tripleClick && $self['tripleClick'] = $tripleClick;
        null !== $type && $self['type'] = $type;
        null !== $wait && $self['wait'] = $wait;
        null !== $zoom && $self['zoom'] = $zoom;

        return $self;
    }

    /**
     * ``close_tab``'s config overrides.
     *
     * @param BetaBrowserCloseTabConfig|BetaBrowserCloseTabConfigShape|null $closeTab
     */
    public function withCloseTab(
        BetaBrowserCloseTabConfig|array|null $closeTab
    ): self {
        $self = clone $this;
        $self['closeTab'] = $closeTab;

        return $self;
    }

    /**
     * ``double_click``'s config overrides.
     *
     * @param BetaBrowserDoubleClickConfig|BetaBrowserDoubleClickConfigShape|null $doubleClick
     */
    public function withDoubleClick(
        BetaBrowserDoubleClickConfig|array|null $doubleClick
    ): self {
        $self = clone $this;
        $self['doubleClick'] = $doubleClick;

        return $self;
    }

    /**
     * ``file_upload``'s config overrides.
     *
     * @param BetaBrowserFileUploadConfig|BetaBrowserFileUploadConfigShape|null $fileUpload
     */
    public function withFileUpload(
        BetaBrowserFileUploadConfig|array|null $fileUpload
    ): self {
        $self = clone $this;
        $self['fileUpload'] = $fileUpload;

        return $self;
    }

    /**
     * ``find``'s config overrides.
     *
     * @param BetaBrowserFindConfig|BetaBrowserFindConfigShape|null $find
     */
    public function withFind(BetaBrowserFindConfig|array|null $find): self
    {
        $self = clone $this;
        $self['find'] = $find;

        return $self;
    }

    /**
     * ``form_input``'s config overrides.
     *
     * @param BetaBrowserFormInputConfig|BetaBrowserFormInputConfigShape|null $formInput
     */
    public function withFormInput(
        BetaBrowserFormInputConfig|array|null $formInput
    ): self {
        $self = clone $this;
        $self['formInput'] = $formInput;

        return $self;
    }

    /**
     * ``get_page_text``'s config overrides.
     *
     * @param BetaBrowserGetPageTextConfig|BetaBrowserGetPageTextConfigShape|null $getPageText
     */
    public function withGetPageText(
        BetaBrowserGetPageTextConfig|array|null $getPageText
    ): self {
        $self = clone $this;
        $self['getPageText'] = $getPageText;

        return $self;
    }

    /**
     * ``hold_key``'s config overrides.
     *
     * @param BetaBrowserHoldKeyConfig|BetaBrowserHoldKeyConfigShape|null $holdKey
     */
    public function withHoldKey(
        BetaBrowserHoldKeyConfig|array|null $holdKey
    ): self {
        $self = clone $this;
        $self['holdKey'] = $holdKey;

        return $self;
    }

    /**
     * ``hover``'s config overrides.
     *
     * @param BetaBrowserHoverConfig|BetaBrowserHoverConfigShape|null $hover
     */
    public function withHover(BetaBrowserHoverConfig|array|null $hover): self
    {
        $self = clone $this;
        $self['hover'] = $hover;

        return $self;
    }

    /**
     * ``javascript_exec``'s config overrides.
     *
     * @param BetaBrowserJavascriptExecConfig|BetaBrowserJavascriptExecConfigShape|null $javascriptExec
     */
    public function withJavascriptExec(
        BetaBrowserJavascriptExecConfig|array|null $javascriptExec
    ): self {
        $self = clone $this;
        $self['javascriptExec'] = $javascriptExec;

        return $self;
    }

    /**
     * ``key``'s config overrides.
     *
     * @param BetaBrowserKeyConfig|BetaBrowserKeyConfigShape|null $key
     */
    public function withKey(BetaBrowserKeyConfig|array|null $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * ``left_click``'s config overrides.
     *
     * @param BetaBrowserLeftClickConfig|BetaBrowserLeftClickConfigShape|null $leftClick
     */
    public function withLeftClick(
        BetaBrowserLeftClickConfig|array|null $leftClick
    ): self {
        $self = clone $this;
        $self['leftClick'] = $leftClick;

        return $self;
    }

    /**
     * ``left_click_drag``'s config overrides.
     *
     * @param BetaBrowserLeftClickDragConfig|BetaBrowserLeftClickDragConfigShape|null $leftClickDrag
     */
    public function withLeftClickDrag(
        BetaBrowserLeftClickDragConfig|array|null $leftClickDrag
    ): self {
        $self = clone $this;
        $self['leftClickDrag'] = $leftClickDrag;

        return $self;
    }

    /**
     * ``left_mouse_down``'s config overrides.
     *
     * @param BetaBrowserLeftMouseDownConfig|BetaBrowserLeftMouseDownConfigShape|null $leftMouseDown
     */
    public function withLeftMouseDown(
        BetaBrowserLeftMouseDownConfig|array|null $leftMouseDown
    ): self {
        $self = clone $this;
        $self['leftMouseDown'] = $leftMouseDown;

        return $self;
    }

    /**
     * ``left_mouse_up``'s config overrides.
     *
     * @param BetaBrowserLeftMouseUpConfig|BetaBrowserLeftMouseUpConfigShape|null $leftMouseUp
     */
    public function withLeftMouseUp(
        BetaBrowserLeftMouseUpConfig|array|null $leftMouseUp
    ): self {
        $self = clone $this;
        $self['leftMouseUp'] = $leftMouseUp;

        return $self;
    }

    /**
     * ``list_tabs``'s config overrides.
     *
     * @param BetaBrowserListTabsConfig|BetaBrowserListTabsConfigShape|null $listTabs
     */
    public function withListTabs(
        BetaBrowserListTabsConfig|array|null $listTabs
    ): self {
        $self = clone $this;
        $self['listTabs'] = $listTabs;

        return $self;
    }

    /**
     * ``middle_click``'s config overrides.
     *
     * @param BetaBrowserMiddleClickConfig|BetaBrowserMiddleClickConfigShape|null $middleClick
     */
    public function withMiddleClick(
        BetaBrowserMiddleClickConfig|array|null $middleClick
    ): self {
        $self = clone $this;
        $self['middleClick'] = $middleClick;

        return $self;
    }

    /**
     * ``mouse_move``'s config overrides.
     *
     * @param BetaBrowserMouseMoveConfig|BetaBrowserMouseMoveConfigShape|null $mouseMove
     */
    public function withMouseMove(
        BetaBrowserMouseMoveConfig|array|null $mouseMove
    ): self {
        $self = clone $this;
        $self['mouseMove'] = $mouseMove;

        return $self;
    }

    /**
     * ``navigate``'s config overrides.
     *
     * @param BetaBrowserNavigateConfig|BetaBrowserNavigateConfigShape|null $navigate
     */
    public function withNavigate(
        BetaBrowserNavigateConfig|array|null $navigate
    ): self {
        $self = clone $this;
        $self['navigate'] = $navigate;

        return $self;
    }

    /**
     * ``new_tab``'s config overrides.
     *
     * @param BetaBrowserNewTabConfig|BetaBrowserNewTabConfigShape|null $newTab
     */
    public function withNewTab(BetaBrowserNewTabConfig|array|null $newTab): self
    {
        $self = clone $this;
        $self['newTab'] = $newTab;

        return $self;
    }

    /**
     * ``read_console``'s config overrides.
     *
     * @param BetaBrowserReadConsoleConfig|BetaBrowserReadConsoleConfigShape|null $readConsole
     */
    public function withReadConsole(
        BetaBrowserReadConsoleConfig|array|null $readConsole
    ): self {
        $self = clone $this;
        $self['readConsole'] = $readConsole;

        return $self;
    }

    /**
     * ``read_network``'s config overrides.
     *
     * @param BetaBrowserReadNetworkConfig|BetaBrowserReadNetworkConfigShape|null $readNetwork
     */
    public function withReadNetwork(
        BetaBrowserReadNetworkConfig|array|null $readNetwork
    ): self {
        $self = clone $this;
        $self['readNetwork'] = $readNetwork;

        return $self;
    }

    /**
     * ``read_page``'s config overrides.
     *
     * @param BetaBrowserReadPageConfig|BetaBrowserReadPageConfigShape|null $readPage
     */
    public function withReadPage(
        BetaBrowserReadPageConfig|array|null $readPage
    ): self {
        $self = clone $this;
        $self['readPage'] = $readPage;

        return $self;
    }

    /**
     * ``right_click``'s config overrides.
     *
     * @param BetaBrowserRightClickConfig|BetaBrowserRightClickConfigShape|null $rightClick
     */
    public function withRightClick(
        BetaBrowserRightClickConfig|array|null $rightClick
    ): self {
        $self = clone $this;
        $self['rightClick'] = $rightClick;

        return $self;
    }

    /**
     * ``screenshot``'s config overrides.
     *
     * @param BetaBrowserScreenshotConfig|BetaBrowserScreenshotConfigShape|null $screenshot
     */
    public function withScreenshot(
        BetaBrowserScreenshotConfig|array|null $screenshot
    ): self {
        $self = clone $this;
        $self['screenshot'] = $screenshot;

        return $self;
    }

    /**
     * ``scroll``'s config overrides.
     *
     * @param BetaBrowserScrollConfig|BetaBrowserScrollConfigShape|null $scroll
     */
    public function withScroll(BetaBrowserScrollConfig|array|null $scroll): self
    {
        $self = clone $this;
        $self['scroll'] = $scroll;

        return $self;
    }

    /**
     * ``scroll_to``'s config overrides.
     *
     * @param BetaBrowserScrollToConfig|BetaBrowserScrollToConfigShape|null $scrollTo
     */
    public function withScrollTo(
        BetaBrowserScrollToConfig|array|null $scrollTo
    ): self {
        $self = clone $this;
        $self['scrollTo'] = $scrollTo;

        return $self;
    }

    /**
     * ``switch_tab``'s config overrides.
     *
     * @param BetaBrowserSwitchTabConfig|BetaBrowserSwitchTabConfigShape|null $switchTab
     */
    public function withSwitchTab(
        BetaBrowserSwitchTabConfig|array|null $switchTab
    ): self {
        $self = clone $this;
        $self['switchTab'] = $switchTab;

        return $self;
    }

    /**
     * ``triple_click``'s config overrides.
     *
     * @param BetaBrowserTripleClickConfig|BetaBrowserTripleClickConfigShape|null $tripleClick
     */
    public function withTripleClick(
        BetaBrowserTripleClickConfig|array|null $tripleClick
    ): self {
        $self = clone $this;
        $self['tripleClick'] = $tripleClick;

        return $self;
    }

    /**
     * ``type``'s config overrides.
     *
     * @param BetaBrowserTypeConfig|BetaBrowserTypeConfigShape|null $type
     */
    public function withType(BetaBrowserTypeConfig|array|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ``wait``'s config overrides.
     *
     * @param BetaBrowserWaitConfig|BetaBrowserWaitConfigShape|null $wait
     */
    public function withWait(BetaBrowserWaitConfig|array|null $wait): self
    {
        $self = clone $this;
        $self['wait'] = $wait;

        return $self;
    }

    /**
     * ``zoom``'s config overrides.
     *
     * @param BetaBrowserZoomConfig|BetaBrowserZoomConfigShape|null $zoom
     */
    public function withZoom(BetaBrowserZoomConfig|array|null $zoom): self
    {
        $self = clone $this;
        $self['zoom'] = $zoom;

        return $self;
    }
}
