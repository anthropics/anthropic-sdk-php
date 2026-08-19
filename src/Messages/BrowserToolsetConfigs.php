<?php

declare(strict_types=1);

namespace Anthropic\Messages;

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
 * @phpstan-import-type BrowserCloseTabConfigShape from \Anthropic\Messages\BrowserCloseTabConfig
 * @phpstan-import-type BrowserDoubleClickConfigShape from \Anthropic\Messages\BrowserDoubleClickConfig
 * @phpstan-import-type BrowserFileUploadConfigShape from \Anthropic\Messages\BrowserFileUploadConfig
 * @phpstan-import-type BrowserFindConfigShape from \Anthropic\Messages\BrowserFindConfig
 * @phpstan-import-type BrowserFormInputConfigShape from \Anthropic\Messages\BrowserFormInputConfig
 * @phpstan-import-type BrowserGetPageTextConfigShape from \Anthropic\Messages\BrowserGetPageTextConfig
 * @phpstan-import-type BrowserHoldKeyConfigShape from \Anthropic\Messages\BrowserHoldKeyConfig
 * @phpstan-import-type BrowserHoverConfigShape from \Anthropic\Messages\BrowserHoverConfig
 * @phpstan-import-type BrowserJavascriptExecConfigShape from \Anthropic\Messages\BrowserJavascriptExecConfig
 * @phpstan-import-type BrowserKeyConfigShape from \Anthropic\Messages\BrowserKeyConfig
 * @phpstan-import-type BrowserLeftClickConfigShape from \Anthropic\Messages\BrowserLeftClickConfig
 * @phpstan-import-type BrowserLeftClickDragConfigShape from \Anthropic\Messages\BrowserLeftClickDragConfig
 * @phpstan-import-type BrowserLeftMouseDownConfigShape from \Anthropic\Messages\BrowserLeftMouseDownConfig
 * @phpstan-import-type BrowserLeftMouseUpConfigShape from \Anthropic\Messages\BrowserLeftMouseUpConfig
 * @phpstan-import-type BrowserListTabsConfigShape from \Anthropic\Messages\BrowserListTabsConfig
 * @phpstan-import-type BrowserMiddleClickConfigShape from \Anthropic\Messages\BrowserMiddleClickConfig
 * @phpstan-import-type BrowserMouseMoveConfigShape from \Anthropic\Messages\BrowserMouseMoveConfig
 * @phpstan-import-type BrowserNavigateConfigShape from \Anthropic\Messages\BrowserNavigateConfig
 * @phpstan-import-type BrowserNewTabConfigShape from \Anthropic\Messages\BrowserNewTabConfig
 * @phpstan-import-type BrowserReadConsoleConfigShape from \Anthropic\Messages\BrowserReadConsoleConfig
 * @phpstan-import-type BrowserReadNetworkConfigShape from \Anthropic\Messages\BrowserReadNetworkConfig
 * @phpstan-import-type BrowserReadPageConfigShape from \Anthropic\Messages\BrowserReadPageConfig
 * @phpstan-import-type BrowserRightClickConfigShape from \Anthropic\Messages\BrowserRightClickConfig
 * @phpstan-import-type BrowserScreenshotConfigShape from \Anthropic\Messages\BrowserScreenshotConfig
 * @phpstan-import-type BrowserScrollConfigShape from \Anthropic\Messages\BrowserScrollConfig
 * @phpstan-import-type BrowserScrollToConfigShape from \Anthropic\Messages\BrowserScrollToConfig
 * @phpstan-import-type BrowserSwitchTabConfigShape from \Anthropic\Messages\BrowserSwitchTabConfig
 * @phpstan-import-type BrowserTripleClickConfigShape from \Anthropic\Messages\BrowserTripleClickConfig
 * @phpstan-import-type BrowserTypeConfigShape from \Anthropic\Messages\BrowserTypeConfig
 * @phpstan-import-type BrowserWaitConfigShape from \Anthropic\Messages\BrowserWaitConfig
 * @phpstan-import-type BrowserZoomConfigShape from \Anthropic\Messages\BrowserZoomConfig
 *
 * @phpstan-type BrowserToolsetConfigsShape = array{
 *   closeTab?: null|BrowserCloseTabConfig|BrowserCloseTabConfigShape,
 *   doubleClick?: null|BrowserDoubleClickConfig|BrowserDoubleClickConfigShape,
 *   fileUpload?: null|BrowserFileUploadConfig|BrowserFileUploadConfigShape,
 *   find?: null|BrowserFindConfig|BrowserFindConfigShape,
 *   formInput?: null|BrowserFormInputConfig|BrowserFormInputConfigShape,
 *   getPageText?: null|BrowserGetPageTextConfig|BrowserGetPageTextConfigShape,
 *   holdKey?: null|BrowserHoldKeyConfig|BrowserHoldKeyConfigShape,
 *   hover?: null|BrowserHoverConfig|BrowserHoverConfigShape,
 *   javascriptExec?: null|BrowserJavascriptExecConfig|BrowserJavascriptExecConfigShape,
 *   key?: null|BrowserKeyConfig|BrowserKeyConfigShape,
 *   leftClick?: null|BrowserLeftClickConfig|BrowserLeftClickConfigShape,
 *   leftClickDrag?: null|BrowserLeftClickDragConfig|BrowserLeftClickDragConfigShape,
 *   leftMouseDown?: null|BrowserLeftMouseDownConfig|BrowserLeftMouseDownConfigShape,
 *   leftMouseUp?: null|BrowserLeftMouseUpConfig|BrowserLeftMouseUpConfigShape,
 *   listTabs?: null|BrowserListTabsConfig|BrowserListTabsConfigShape,
 *   middleClick?: null|BrowserMiddleClickConfig|BrowserMiddleClickConfigShape,
 *   mouseMove?: null|BrowserMouseMoveConfig|BrowserMouseMoveConfigShape,
 *   navigate?: null|BrowserNavigateConfig|BrowserNavigateConfigShape,
 *   newTab?: null|BrowserNewTabConfig|BrowserNewTabConfigShape,
 *   readConsole?: null|BrowserReadConsoleConfig|BrowserReadConsoleConfigShape,
 *   readNetwork?: null|BrowserReadNetworkConfig|BrowserReadNetworkConfigShape,
 *   readPage?: null|BrowserReadPageConfig|BrowserReadPageConfigShape,
 *   rightClick?: null|BrowserRightClickConfig|BrowserRightClickConfigShape,
 *   screenshot?: null|BrowserScreenshotConfig|BrowserScreenshotConfigShape,
 *   scroll?: null|BrowserScrollConfig|BrowserScrollConfigShape,
 *   scrollTo?: null|BrowserScrollToConfig|BrowserScrollToConfigShape,
 *   switchTab?: null|BrowserSwitchTabConfig|BrowserSwitchTabConfigShape,
 *   tripleClick?: null|BrowserTripleClickConfig|BrowserTripleClickConfigShape,
 *   type?: null|BrowserTypeConfig|BrowserTypeConfigShape,
 *   wait?: null|BrowserWaitConfig|BrowserWaitConfigShape,
 *   zoom?: null|BrowserZoomConfig|BrowserZoomConfigShape,
 * }
 */
final class BrowserToolsetConfigs implements BaseModel
{
    /** @use SdkModel<BrowserToolsetConfigsShape> */
    use SdkModel;

    /**
     * ``close_tab``'s config overrides.
     */
    #[Optional('close_tab', nullable: true)]
    public ?BrowserCloseTabConfig $closeTab;

    /**
     * ``double_click``'s config overrides.
     */
    #[Optional('double_click', nullable: true)]
    public ?BrowserDoubleClickConfig $doubleClick;

    /**
     * ``file_upload``'s config overrides.
     */
    #[Optional('file_upload', nullable: true)]
    public ?BrowserFileUploadConfig $fileUpload;

    /**
     * ``find``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserFindConfig $find;

    /**
     * ``form_input``'s config overrides.
     */
    #[Optional('form_input', nullable: true)]
    public ?BrowserFormInputConfig $formInput;

    /**
     * ``get_page_text``'s config overrides.
     */
    #[Optional('get_page_text', nullable: true)]
    public ?BrowserGetPageTextConfig $getPageText;

    /**
     * ``hold_key``'s config overrides.
     */
    #[Optional('hold_key', nullable: true)]
    public ?BrowserHoldKeyConfig $holdKey;

    /**
     * ``hover``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserHoverConfig $hover;

    /**
     * ``javascript_exec``'s config overrides.
     */
    #[Optional('javascript_exec', nullable: true)]
    public ?BrowserJavascriptExecConfig $javascriptExec;

    /**
     * ``key``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserKeyConfig $key;

    /**
     * ``left_click``'s config overrides.
     */
    #[Optional('left_click', nullable: true)]
    public ?BrowserLeftClickConfig $leftClick;

    /**
     * ``left_click_drag``'s config overrides.
     */
    #[Optional('left_click_drag', nullable: true)]
    public ?BrowserLeftClickDragConfig $leftClickDrag;

    /**
     * ``left_mouse_down``'s config overrides.
     */
    #[Optional('left_mouse_down', nullable: true)]
    public ?BrowserLeftMouseDownConfig $leftMouseDown;

    /**
     * ``left_mouse_up``'s config overrides.
     */
    #[Optional('left_mouse_up', nullable: true)]
    public ?BrowserLeftMouseUpConfig $leftMouseUp;

    /**
     * ``list_tabs``'s config overrides.
     */
    #[Optional('list_tabs', nullable: true)]
    public ?BrowserListTabsConfig $listTabs;

    /**
     * ``middle_click``'s config overrides.
     */
    #[Optional('middle_click', nullable: true)]
    public ?BrowserMiddleClickConfig $middleClick;

    /**
     * ``mouse_move``'s config overrides.
     */
    #[Optional('mouse_move', nullable: true)]
    public ?BrowserMouseMoveConfig $mouseMove;

    /**
     * ``navigate``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserNavigateConfig $navigate;

    /**
     * ``new_tab``'s config overrides.
     */
    #[Optional('new_tab', nullable: true)]
    public ?BrowserNewTabConfig $newTab;

    /**
     * ``read_console``'s config overrides.
     */
    #[Optional('read_console', nullable: true)]
    public ?BrowserReadConsoleConfig $readConsole;

    /**
     * ``read_network``'s config overrides.
     */
    #[Optional('read_network', nullable: true)]
    public ?BrowserReadNetworkConfig $readNetwork;

    /**
     * ``read_page``'s config overrides.
     */
    #[Optional('read_page', nullable: true)]
    public ?BrowserReadPageConfig $readPage;

    /**
     * ``right_click``'s config overrides.
     */
    #[Optional('right_click', nullable: true)]
    public ?BrowserRightClickConfig $rightClick;

    /**
     * ``screenshot``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserScreenshotConfig $screenshot;

    /**
     * ``scroll``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserScrollConfig $scroll;

    /**
     * ``scroll_to``'s config overrides.
     */
    #[Optional('scroll_to', nullable: true)]
    public ?BrowserScrollToConfig $scrollTo;

    /**
     * ``switch_tab``'s config overrides.
     */
    #[Optional('switch_tab', nullable: true)]
    public ?BrowserSwitchTabConfig $switchTab;

    /**
     * ``triple_click``'s config overrides.
     */
    #[Optional('triple_click', nullable: true)]
    public ?BrowserTripleClickConfig $tripleClick;

    /**
     * ``type``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserTypeConfig $type;

    /**
     * ``wait``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserWaitConfig $wait;

    /**
     * ``zoom``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?BrowserZoomConfig $zoom;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BrowserCloseTabConfig|BrowserCloseTabConfigShape|null $closeTab
     * @param BrowserDoubleClickConfig|BrowserDoubleClickConfigShape|null $doubleClick
     * @param BrowserFileUploadConfig|BrowserFileUploadConfigShape|null $fileUpload
     * @param BrowserFindConfig|BrowserFindConfigShape|null $find
     * @param BrowserFormInputConfig|BrowserFormInputConfigShape|null $formInput
     * @param BrowserGetPageTextConfig|BrowserGetPageTextConfigShape|null $getPageText
     * @param BrowserHoldKeyConfig|BrowserHoldKeyConfigShape|null $holdKey
     * @param BrowserHoverConfig|BrowserHoverConfigShape|null $hover
     * @param BrowserJavascriptExecConfig|BrowserJavascriptExecConfigShape|null $javascriptExec
     * @param BrowserKeyConfig|BrowserKeyConfigShape|null $key
     * @param BrowserLeftClickConfig|BrowserLeftClickConfigShape|null $leftClick
     * @param BrowserLeftClickDragConfig|BrowserLeftClickDragConfigShape|null $leftClickDrag
     * @param BrowserLeftMouseDownConfig|BrowserLeftMouseDownConfigShape|null $leftMouseDown
     * @param BrowserLeftMouseUpConfig|BrowserLeftMouseUpConfigShape|null $leftMouseUp
     * @param BrowserListTabsConfig|BrowserListTabsConfigShape|null $listTabs
     * @param BrowserMiddleClickConfig|BrowserMiddleClickConfigShape|null $middleClick
     * @param BrowserMouseMoveConfig|BrowserMouseMoveConfigShape|null $mouseMove
     * @param BrowserNavigateConfig|BrowserNavigateConfigShape|null $navigate
     * @param BrowserNewTabConfig|BrowserNewTabConfigShape|null $newTab
     * @param BrowserReadConsoleConfig|BrowserReadConsoleConfigShape|null $readConsole
     * @param BrowserReadNetworkConfig|BrowserReadNetworkConfigShape|null $readNetwork
     * @param BrowserReadPageConfig|BrowserReadPageConfigShape|null $readPage
     * @param BrowserRightClickConfig|BrowserRightClickConfigShape|null $rightClick
     * @param BrowserScreenshotConfig|BrowserScreenshotConfigShape|null $screenshot
     * @param BrowserScrollConfig|BrowserScrollConfigShape|null $scroll
     * @param BrowserScrollToConfig|BrowserScrollToConfigShape|null $scrollTo
     * @param BrowserSwitchTabConfig|BrowserSwitchTabConfigShape|null $switchTab
     * @param BrowserTripleClickConfig|BrowserTripleClickConfigShape|null $tripleClick
     * @param BrowserTypeConfig|BrowserTypeConfigShape|null $type
     * @param BrowserWaitConfig|BrowserWaitConfigShape|null $wait
     * @param BrowserZoomConfig|BrowserZoomConfigShape|null $zoom
     */
    public static function with(
        BrowserCloseTabConfig|array|null $closeTab = null,
        BrowserDoubleClickConfig|array|null $doubleClick = null,
        BrowserFileUploadConfig|array|null $fileUpload = null,
        BrowserFindConfig|array|null $find = null,
        BrowserFormInputConfig|array|null $formInput = null,
        BrowserGetPageTextConfig|array|null $getPageText = null,
        BrowserHoldKeyConfig|array|null $holdKey = null,
        BrowserHoverConfig|array|null $hover = null,
        BrowserJavascriptExecConfig|array|null $javascriptExec = null,
        BrowserKeyConfig|array|null $key = null,
        BrowserLeftClickConfig|array|null $leftClick = null,
        BrowserLeftClickDragConfig|array|null $leftClickDrag = null,
        BrowserLeftMouseDownConfig|array|null $leftMouseDown = null,
        BrowserLeftMouseUpConfig|array|null $leftMouseUp = null,
        BrowserListTabsConfig|array|null $listTabs = null,
        BrowserMiddleClickConfig|array|null $middleClick = null,
        BrowserMouseMoveConfig|array|null $mouseMove = null,
        BrowserNavigateConfig|array|null $navigate = null,
        BrowserNewTabConfig|array|null $newTab = null,
        BrowserReadConsoleConfig|array|null $readConsole = null,
        BrowserReadNetworkConfig|array|null $readNetwork = null,
        BrowserReadPageConfig|array|null $readPage = null,
        BrowserRightClickConfig|array|null $rightClick = null,
        BrowserScreenshotConfig|array|null $screenshot = null,
        BrowserScrollConfig|array|null $scroll = null,
        BrowserScrollToConfig|array|null $scrollTo = null,
        BrowserSwitchTabConfig|array|null $switchTab = null,
        BrowserTripleClickConfig|array|null $tripleClick = null,
        BrowserTypeConfig|array|null $type = null,
        BrowserWaitConfig|array|null $wait = null,
        BrowserZoomConfig|array|null $zoom = null,
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
     * @param BrowserCloseTabConfig|BrowserCloseTabConfigShape|null $closeTab
     */
    public function withCloseTab(
        BrowserCloseTabConfig|array|null $closeTab
    ): self {
        $self = clone $this;
        $self['closeTab'] = $closeTab;

        return $self;
    }

    /**
     * ``double_click``'s config overrides.
     *
     * @param BrowserDoubleClickConfig|BrowserDoubleClickConfigShape|null $doubleClick
     */
    public function withDoubleClick(
        BrowserDoubleClickConfig|array|null $doubleClick
    ): self {
        $self = clone $this;
        $self['doubleClick'] = $doubleClick;

        return $self;
    }

    /**
     * ``file_upload``'s config overrides.
     *
     * @param BrowserFileUploadConfig|BrowserFileUploadConfigShape|null $fileUpload
     */
    public function withFileUpload(
        BrowserFileUploadConfig|array|null $fileUpload
    ): self {
        $self = clone $this;
        $self['fileUpload'] = $fileUpload;

        return $self;
    }

    /**
     * ``find``'s config overrides.
     *
     * @param BrowserFindConfig|BrowserFindConfigShape|null $find
     */
    public function withFind(BrowserFindConfig|array|null $find): self
    {
        $self = clone $this;
        $self['find'] = $find;

        return $self;
    }

    /**
     * ``form_input``'s config overrides.
     *
     * @param BrowserFormInputConfig|BrowserFormInputConfigShape|null $formInput
     */
    public function withFormInput(
        BrowserFormInputConfig|array|null $formInput
    ): self {
        $self = clone $this;
        $self['formInput'] = $formInput;

        return $self;
    }

    /**
     * ``get_page_text``'s config overrides.
     *
     * @param BrowserGetPageTextConfig|BrowserGetPageTextConfigShape|null $getPageText
     */
    public function withGetPageText(
        BrowserGetPageTextConfig|array|null $getPageText
    ): self {
        $self = clone $this;
        $self['getPageText'] = $getPageText;

        return $self;
    }

    /**
     * ``hold_key``'s config overrides.
     *
     * @param BrowserHoldKeyConfig|BrowserHoldKeyConfigShape|null $holdKey
     */
    public function withHoldKey(BrowserHoldKeyConfig|array|null $holdKey): self
    {
        $self = clone $this;
        $self['holdKey'] = $holdKey;

        return $self;
    }

    /**
     * ``hover``'s config overrides.
     *
     * @param BrowserHoverConfig|BrowserHoverConfigShape|null $hover
     */
    public function withHover(BrowserHoverConfig|array|null $hover): self
    {
        $self = clone $this;
        $self['hover'] = $hover;

        return $self;
    }

    /**
     * ``javascript_exec``'s config overrides.
     *
     * @param BrowserJavascriptExecConfig|BrowserJavascriptExecConfigShape|null $javascriptExec
     */
    public function withJavascriptExec(
        BrowserJavascriptExecConfig|array|null $javascriptExec
    ): self {
        $self = clone $this;
        $self['javascriptExec'] = $javascriptExec;

        return $self;
    }

    /**
     * ``key``'s config overrides.
     *
     * @param BrowserKeyConfig|BrowserKeyConfigShape|null $key
     */
    public function withKey(BrowserKeyConfig|array|null $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * ``left_click``'s config overrides.
     *
     * @param BrowserLeftClickConfig|BrowserLeftClickConfigShape|null $leftClick
     */
    public function withLeftClick(
        BrowserLeftClickConfig|array|null $leftClick
    ): self {
        $self = clone $this;
        $self['leftClick'] = $leftClick;

        return $self;
    }

    /**
     * ``left_click_drag``'s config overrides.
     *
     * @param BrowserLeftClickDragConfig|BrowserLeftClickDragConfigShape|null $leftClickDrag
     */
    public function withLeftClickDrag(
        BrowserLeftClickDragConfig|array|null $leftClickDrag
    ): self {
        $self = clone $this;
        $self['leftClickDrag'] = $leftClickDrag;

        return $self;
    }

    /**
     * ``left_mouse_down``'s config overrides.
     *
     * @param BrowserLeftMouseDownConfig|BrowserLeftMouseDownConfigShape|null $leftMouseDown
     */
    public function withLeftMouseDown(
        BrowserLeftMouseDownConfig|array|null $leftMouseDown
    ): self {
        $self = clone $this;
        $self['leftMouseDown'] = $leftMouseDown;

        return $self;
    }

    /**
     * ``left_mouse_up``'s config overrides.
     *
     * @param BrowserLeftMouseUpConfig|BrowserLeftMouseUpConfigShape|null $leftMouseUp
     */
    public function withLeftMouseUp(
        BrowserLeftMouseUpConfig|array|null $leftMouseUp
    ): self {
        $self = clone $this;
        $self['leftMouseUp'] = $leftMouseUp;

        return $self;
    }

    /**
     * ``list_tabs``'s config overrides.
     *
     * @param BrowserListTabsConfig|BrowserListTabsConfigShape|null $listTabs
     */
    public function withListTabs(
        BrowserListTabsConfig|array|null $listTabs
    ): self {
        $self = clone $this;
        $self['listTabs'] = $listTabs;

        return $self;
    }

    /**
     * ``middle_click``'s config overrides.
     *
     * @param BrowserMiddleClickConfig|BrowserMiddleClickConfigShape|null $middleClick
     */
    public function withMiddleClick(
        BrowserMiddleClickConfig|array|null $middleClick
    ): self {
        $self = clone $this;
        $self['middleClick'] = $middleClick;

        return $self;
    }

    /**
     * ``mouse_move``'s config overrides.
     *
     * @param BrowserMouseMoveConfig|BrowserMouseMoveConfigShape|null $mouseMove
     */
    public function withMouseMove(
        BrowserMouseMoveConfig|array|null $mouseMove
    ): self {
        $self = clone $this;
        $self['mouseMove'] = $mouseMove;

        return $self;
    }

    /**
     * ``navigate``'s config overrides.
     *
     * @param BrowserNavigateConfig|BrowserNavigateConfigShape|null $navigate
     */
    public function withNavigate(
        BrowserNavigateConfig|array|null $navigate
    ): self {
        $self = clone $this;
        $self['navigate'] = $navigate;

        return $self;
    }

    /**
     * ``new_tab``'s config overrides.
     *
     * @param BrowserNewTabConfig|BrowserNewTabConfigShape|null $newTab
     */
    public function withNewTab(BrowserNewTabConfig|array|null $newTab): self
    {
        $self = clone $this;
        $self['newTab'] = $newTab;

        return $self;
    }

    /**
     * ``read_console``'s config overrides.
     *
     * @param BrowserReadConsoleConfig|BrowserReadConsoleConfigShape|null $readConsole
     */
    public function withReadConsole(
        BrowserReadConsoleConfig|array|null $readConsole
    ): self {
        $self = clone $this;
        $self['readConsole'] = $readConsole;

        return $self;
    }

    /**
     * ``read_network``'s config overrides.
     *
     * @param BrowserReadNetworkConfig|BrowserReadNetworkConfigShape|null $readNetwork
     */
    public function withReadNetwork(
        BrowserReadNetworkConfig|array|null $readNetwork
    ): self {
        $self = clone $this;
        $self['readNetwork'] = $readNetwork;

        return $self;
    }

    /**
     * ``read_page``'s config overrides.
     *
     * @param BrowserReadPageConfig|BrowserReadPageConfigShape|null $readPage
     */
    public function withReadPage(
        BrowserReadPageConfig|array|null $readPage
    ): self {
        $self = clone $this;
        $self['readPage'] = $readPage;

        return $self;
    }

    /**
     * ``right_click``'s config overrides.
     *
     * @param BrowserRightClickConfig|BrowserRightClickConfigShape|null $rightClick
     */
    public function withRightClick(
        BrowserRightClickConfig|array|null $rightClick
    ): self {
        $self = clone $this;
        $self['rightClick'] = $rightClick;

        return $self;
    }

    /**
     * ``screenshot``'s config overrides.
     *
     * @param BrowserScreenshotConfig|BrowserScreenshotConfigShape|null $screenshot
     */
    public function withScreenshot(
        BrowserScreenshotConfig|array|null $screenshot
    ): self {
        $self = clone $this;
        $self['screenshot'] = $screenshot;

        return $self;
    }

    /**
     * ``scroll``'s config overrides.
     *
     * @param BrowserScrollConfig|BrowserScrollConfigShape|null $scroll
     */
    public function withScroll(BrowserScrollConfig|array|null $scroll): self
    {
        $self = clone $this;
        $self['scroll'] = $scroll;

        return $self;
    }

    /**
     * ``scroll_to``'s config overrides.
     *
     * @param BrowserScrollToConfig|BrowserScrollToConfigShape|null $scrollTo
     */
    public function withScrollTo(
        BrowserScrollToConfig|array|null $scrollTo
    ): self {
        $self = clone $this;
        $self['scrollTo'] = $scrollTo;

        return $self;
    }

    /**
     * ``switch_tab``'s config overrides.
     *
     * @param BrowserSwitchTabConfig|BrowserSwitchTabConfigShape|null $switchTab
     */
    public function withSwitchTab(
        BrowserSwitchTabConfig|array|null $switchTab
    ): self {
        $self = clone $this;
        $self['switchTab'] = $switchTab;

        return $self;
    }

    /**
     * ``triple_click``'s config overrides.
     *
     * @param BrowserTripleClickConfig|BrowserTripleClickConfigShape|null $tripleClick
     */
    public function withTripleClick(
        BrowserTripleClickConfig|array|null $tripleClick
    ): self {
        $self = clone $this;
        $self['tripleClick'] = $tripleClick;

        return $self;
    }

    /**
     * ``type``'s config overrides.
     *
     * @param BrowserTypeConfig|BrowserTypeConfigShape|null $type
     */
    public function withType(BrowserTypeConfig|array|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ``wait``'s config overrides.
     *
     * @param BrowserWaitConfig|BrowserWaitConfigShape|null $wait
     */
    public function withWait(BrowserWaitConfig|array|null $wait): self
    {
        $self = clone $this;
        $self['wait'] = $wait;

        return $self;
    }

    /**
     * ``zoom``'s config overrides.
     *
     * @param BrowserZoomConfig|BrowserZoomConfigShape|null $zoom
     */
    public function withZoom(BrowserZoomConfig|array|null $zoom): self
    {
        $self = clone $this;
        $self['zoom'] = $zoom;

        return $self;
    }
}
