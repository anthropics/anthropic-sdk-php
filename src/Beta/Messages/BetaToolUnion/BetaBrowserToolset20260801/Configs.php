<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801;

use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\CloseTab;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\DoubleClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\FileUpload;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Find;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\FormInput;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\GetPageText;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\HoldKey;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Hover;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\JavascriptExec;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Key;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftClickDrag;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftMouseDown;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftMouseUp;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ListTabs;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\MiddleClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\MouseMove;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Navigate;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\NewTab;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ReadConsole;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ReadNetwork;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ReadPage;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\RightClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Screenshot;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Scroll;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ScrollTo;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\SwitchTab;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\TripleClick;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Type;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Wait;
use Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Zoom;
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
 * @phpstan-import-type CloseTabShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\CloseTab
 * @phpstan-import-type DoubleClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\DoubleClick
 * @phpstan-import-type FileUploadShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\FileUpload
 * @phpstan-import-type FindShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Find
 * @phpstan-import-type FormInputShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\FormInput
 * @phpstan-import-type GetPageTextShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\GetPageText
 * @phpstan-import-type HoldKeyShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\HoldKey
 * @phpstan-import-type HoverShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Hover
 * @phpstan-import-type JavascriptExecShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\JavascriptExec
 * @phpstan-import-type KeyShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Key
 * @phpstan-import-type LeftClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftClick
 * @phpstan-import-type LeftClickDragShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftClickDrag
 * @phpstan-import-type LeftMouseDownShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftMouseDown
 * @phpstan-import-type LeftMouseUpShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\LeftMouseUp
 * @phpstan-import-type ListTabsShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ListTabs
 * @phpstan-import-type MiddleClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\MiddleClick
 * @phpstan-import-type MouseMoveShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\MouseMove
 * @phpstan-import-type NavigateShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Navigate
 * @phpstan-import-type NewTabShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\NewTab
 * @phpstan-import-type ReadConsoleShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ReadConsole
 * @phpstan-import-type ReadNetworkShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ReadNetwork
 * @phpstan-import-type ReadPageShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ReadPage
 * @phpstan-import-type RightClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\RightClick
 * @phpstan-import-type ScreenshotShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Screenshot
 * @phpstan-import-type ScrollShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Scroll
 * @phpstan-import-type ScrollToShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\ScrollTo
 * @phpstan-import-type SwitchTabShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\SwitchTab
 * @phpstan-import-type TripleClickShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\TripleClick
 * @phpstan-import-type TypeShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Type
 * @phpstan-import-type WaitShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Wait
 * @phpstan-import-type ZoomShape from \Anthropic\Beta\Messages\BetaToolUnion\BetaBrowserToolset20260801\Configs\Zoom
 *
 * @phpstan-type ConfigsShape = array{
 *   closeTab?: null|CloseTab|CloseTabShape,
 *   doubleClick?: null|DoubleClick|DoubleClickShape,
 *   fileUpload?: null|FileUpload|FileUploadShape,
 *   find?: null|Find|FindShape,
 *   formInput?: null|FormInput|FormInputShape,
 *   getPageText?: null|GetPageText|GetPageTextShape,
 *   holdKey?: null|HoldKey|HoldKeyShape,
 *   hover?: null|Hover|HoverShape,
 *   javascriptExec?: null|JavascriptExec|JavascriptExecShape,
 *   key?: null|Key|KeyShape,
 *   leftClick?: null|LeftClick|LeftClickShape,
 *   leftClickDrag?: null|LeftClickDrag|LeftClickDragShape,
 *   leftMouseDown?: null|LeftMouseDown|LeftMouseDownShape,
 *   leftMouseUp?: null|LeftMouseUp|LeftMouseUpShape,
 *   listTabs?: null|ListTabs|ListTabsShape,
 *   middleClick?: null|MiddleClick|MiddleClickShape,
 *   mouseMove?: null|MouseMove|MouseMoveShape,
 *   navigate?: null|Navigate|NavigateShape,
 *   newTab?: null|NewTab|NewTabShape,
 *   readConsole?: null|ReadConsole|ReadConsoleShape,
 *   readNetwork?: null|ReadNetwork|ReadNetworkShape,
 *   readPage?: null|ReadPage|ReadPageShape,
 *   rightClick?: null|RightClick|RightClickShape,
 *   screenshot?: null|Screenshot|ScreenshotShape,
 *   scroll?: null|Scroll|ScrollShape,
 *   scrollTo?: null|ScrollTo|ScrollToShape,
 *   switchTab?: null|SwitchTab|SwitchTabShape,
 *   tripleClick?: null|TripleClick|TripleClickShape,
 *   type?: null|Type|TypeShape,
 *   wait?: null|Wait|WaitShape,
 *   zoom?: null|Zoom|ZoomShape,
 * }
 */
final class Configs implements BaseModel
{
    /** @use SdkModel<ConfigsShape> */
    use SdkModel;

    /**
     * ``close_tab``'s config overrides.
     */
    #[Optional('close_tab', nullable: true)]
    public ?CloseTab $closeTab;

    /**
     * ``double_click``'s config overrides.
     */
    #[Optional('double_click', nullable: true)]
    public ?DoubleClick $doubleClick;

    /**
     * ``file_upload``'s config overrides.
     */
    #[Optional('file_upload', nullable: true)]
    public ?FileUpload $fileUpload;

    /**
     * ``find``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Find $find;

    /**
     * ``form_input``'s config overrides.
     */
    #[Optional('form_input', nullable: true)]
    public ?FormInput $formInput;

    /**
     * ``get_page_text``'s config overrides.
     */
    #[Optional('get_page_text', nullable: true)]
    public ?GetPageText $getPageText;

    /**
     * ``hold_key``'s config overrides.
     */
    #[Optional('hold_key', nullable: true)]
    public ?HoldKey $holdKey;

    /**
     * ``hover``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Hover $hover;

    /**
     * ``javascript_exec``'s config overrides.
     */
    #[Optional('javascript_exec', nullable: true)]
    public ?JavascriptExec $javascriptExec;

    /**
     * ``key``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Key $key;

    /**
     * ``left_click``'s config overrides.
     */
    #[Optional('left_click', nullable: true)]
    public ?LeftClick $leftClick;

    /**
     * ``left_click_drag``'s config overrides.
     */
    #[Optional('left_click_drag', nullable: true)]
    public ?LeftClickDrag $leftClickDrag;

    /**
     * ``left_mouse_down``'s config overrides.
     */
    #[Optional('left_mouse_down', nullable: true)]
    public ?LeftMouseDown $leftMouseDown;

    /**
     * ``left_mouse_up``'s config overrides.
     */
    #[Optional('left_mouse_up', nullable: true)]
    public ?LeftMouseUp $leftMouseUp;

    /**
     * ``list_tabs``'s config overrides.
     */
    #[Optional('list_tabs', nullable: true)]
    public ?ListTabs $listTabs;

    /**
     * ``middle_click``'s config overrides.
     */
    #[Optional('middle_click', nullable: true)]
    public ?MiddleClick $middleClick;

    /**
     * ``mouse_move``'s config overrides.
     */
    #[Optional('mouse_move', nullable: true)]
    public ?MouseMove $mouseMove;

    /**
     * ``navigate``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Navigate $navigate;

    /**
     * ``new_tab``'s config overrides.
     */
    #[Optional('new_tab', nullable: true)]
    public ?NewTab $newTab;

    /**
     * ``read_console``'s config overrides.
     */
    #[Optional('read_console', nullable: true)]
    public ?ReadConsole $readConsole;

    /**
     * ``read_network``'s config overrides.
     */
    #[Optional('read_network', nullable: true)]
    public ?ReadNetwork $readNetwork;

    /**
     * ``read_page``'s config overrides.
     */
    #[Optional('read_page', nullable: true)]
    public ?ReadPage $readPage;

    /**
     * ``right_click``'s config overrides.
     */
    #[Optional('right_click', nullable: true)]
    public ?RightClick $rightClick;

    /**
     * ``screenshot``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Screenshot $screenshot;

    /**
     * ``scroll``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Scroll $scroll;

    /**
     * ``scroll_to``'s config overrides.
     */
    #[Optional('scroll_to', nullable: true)]
    public ?ScrollTo $scrollTo;

    /**
     * ``switch_tab``'s config overrides.
     */
    #[Optional('switch_tab', nullable: true)]
    public ?SwitchTab $switchTab;

    /**
     * ``triple_click``'s config overrides.
     */
    #[Optional('triple_click', nullable: true)]
    public ?TripleClick $tripleClick;

    /**
     * ``type``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Type $type;

    /**
     * ``wait``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Wait $wait;

    /**
     * ``zoom``'s config overrides.
     */
    #[Optional(nullable: true)]
    public ?Zoom $zoom;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param CloseTab|CloseTabShape|null $closeTab
     * @param DoubleClick|DoubleClickShape|null $doubleClick
     * @param FileUpload|FileUploadShape|null $fileUpload
     * @param Find|FindShape|null $find
     * @param FormInput|FormInputShape|null $formInput
     * @param GetPageText|GetPageTextShape|null $getPageText
     * @param HoldKey|HoldKeyShape|null $holdKey
     * @param Hover|HoverShape|null $hover
     * @param JavascriptExec|JavascriptExecShape|null $javascriptExec
     * @param Key|KeyShape|null $key
     * @param LeftClick|LeftClickShape|null $leftClick
     * @param LeftClickDrag|LeftClickDragShape|null $leftClickDrag
     * @param LeftMouseDown|LeftMouseDownShape|null $leftMouseDown
     * @param LeftMouseUp|LeftMouseUpShape|null $leftMouseUp
     * @param ListTabs|ListTabsShape|null $listTabs
     * @param MiddleClick|MiddleClickShape|null $middleClick
     * @param MouseMove|MouseMoveShape|null $mouseMove
     * @param Navigate|NavigateShape|null $navigate
     * @param NewTab|NewTabShape|null $newTab
     * @param ReadConsole|ReadConsoleShape|null $readConsole
     * @param ReadNetwork|ReadNetworkShape|null $readNetwork
     * @param ReadPage|ReadPageShape|null $readPage
     * @param RightClick|RightClickShape|null $rightClick
     * @param Screenshot|ScreenshotShape|null $screenshot
     * @param Scroll|ScrollShape|null $scroll
     * @param ScrollTo|ScrollToShape|null $scrollTo
     * @param SwitchTab|SwitchTabShape|null $switchTab
     * @param TripleClick|TripleClickShape|null $tripleClick
     * @param Type|TypeShape|null $type
     * @param Wait|WaitShape|null $wait
     * @param Zoom|ZoomShape|null $zoom
     */
    public static function with(
        CloseTab|array|null $closeTab = null,
        DoubleClick|array|null $doubleClick = null,
        FileUpload|array|null $fileUpload = null,
        Find|array|null $find = null,
        FormInput|array|null $formInput = null,
        GetPageText|array|null $getPageText = null,
        HoldKey|array|null $holdKey = null,
        Hover|array|null $hover = null,
        JavascriptExec|array|null $javascriptExec = null,
        Key|array|null $key = null,
        LeftClick|array|null $leftClick = null,
        LeftClickDrag|array|null $leftClickDrag = null,
        LeftMouseDown|array|null $leftMouseDown = null,
        LeftMouseUp|array|null $leftMouseUp = null,
        ListTabs|array|null $listTabs = null,
        MiddleClick|array|null $middleClick = null,
        MouseMove|array|null $mouseMove = null,
        Navigate|array|null $navigate = null,
        NewTab|array|null $newTab = null,
        ReadConsole|array|null $readConsole = null,
        ReadNetwork|array|null $readNetwork = null,
        ReadPage|array|null $readPage = null,
        RightClick|array|null $rightClick = null,
        Screenshot|array|null $screenshot = null,
        Scroll|array|null $scroll = null,
        ScrollTo|array|null $scrollTo = null,
        SwitchTab|array|null $switchTab = null,
        TripleClick|array|null $tripleClick = null,
        Type|array|null $type = null,
        Wait|array|null $wait = null,
        Zoom|array|null $zoom = null,
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
     * @param CloseTab|CloseTabShape|null $closeTab
     */
    public function withCloseTab(CloseTab|array|null $closeTab): self
    {
        $self = clone $this;
        $self['closeTab'] = $closeTab;

        return $self;
    }

    /**
     * ``double_click``'s config overrides.
     *
     * @param DoubleClick|DoubleClickShape|null $doubleClick
     */
    public function withDoubleClick(DoubleClick|array|null $doubleClick): self
    {
        $self = clone $this;
        $self['doubleClick'] = $doubleClick;

        return $self;
    }

    /**
     * ``file_upload``'s config overrides.
     *
     * @param FileUpload|FileUploadShape|null $fileUpload
     */
    public function withFileUpload(FileUpload|array|null $fileUpload): self
    {
        $self = clone $this;
        $self['fileUpload'] = $fileUpload;

        return $self;
    }

    /**
     * ``find``'s config overrides.
     *
     * @param Find|FindShape|null $find
     */
    public function withFind(Find|array|null $find): self
    {
        $self = clone $this;
        $self['find'] = $find;

        return $self;
    }

    /**
     * ``form_input``'s config overrides.
     *
     * @param FormInput|FormInputShape|null $formInput
     */
    public function withFormInput(FormInput|array|null $formInput): self
    {
        $self = clone $this;
        $self['formInput'] = $formInput;

        return $self;
    }

    /**
     * ``get_page_text``'s config overrides.
     *
     * @param GetPageText|GetPageTextShape|null $getPageText
     */
    public function withGetPageText(GetPageText|array|null $getPageText): self
    {
        $self = clone $this;
        $self['getPageText'] = $getPageText;

        return $self;
    }

    /**
     * ``hold_key``'s config overrides.
     *
     * @param HoldKey|HoldKeyShape|null $holdKey
     */
    public function withHoldKey(HoldKey|array|null $holdKey): self
    {
        $self = clone $this;
        $self['holdKey'] = $holdKey;

        return $self;
    }

    /**
     * ``hover``'s config overrides.
     *
     * @param Hover|HoverShape|null $hover
     */
    public function withHover(Hover|array|null $hover): self
    {
        $self = clone $this;
        $self['hover'] = $hover;

        return $self;
    }

    /**
     * ``javascript_exec``'s config overrides.
     *
     * @param JavascriptExec|JavascriptExecShape|null $javascriptExec
     */
    public function withJavascriptExec(
        JavascriptExec|array|null $javascriptExec
    ): self {
        $self = clone $this;
        $self['javascriptExec'] = $javascriptExec;

        return $self;
    }

    /**
     * ``key``'s config overrides.
     *
     * @param Key|KeyShape|null $key
     */
    public function withKey(Key|array|null $key): self
    {
        $self = clone $this;
        $self['key'] = $key;

        return $self;
    }

    /**
     * ``left_click``'s config overrides.
     *
     * @param LeftClick|LeftClickShape|null $leftClick
     */
    public function withLeftClick(LeftClick|array|null $leftClick): self
    {
        $self = clone $this;
        $self['leftClick'] = $leftClick;

        return $self;
    }

    /**
     * ``left_click_drag``'s config overrides.
     *
     * @param LeftClickDrag|LeftClickDragShape|null $leftClickDrag
     */
    public function withLeftClickDrag(
        LeftClickDrag|array|null $leftClickDrag
    ): self {
        $self = clone $this;
        $self['leftClickDrag'] = $leftClickDrag;

        return $self;
    }

    /**
     * ``left_mouse_down``'s config overrides.
     *
     * @param LeftMouseDown|LeftMouseDownShape|null $leftMouseDown
     */
    public function withLeftMouseDown(
        LeftMouseDown|array|null $leftMouseDown
    ): self {
        $self = clone $this;
        $self['leftMouseDown'] = $leftMouseDown;

        return $self;
    }

    /**
     * ``left_mouse_up``'s config overrides.
     *
     * @param LeftMouseUp|LeftMouseUpShape|null $leftMouseUp
     */
    public function withLeftMouseUp(LeftMouseUp|array|null $leftMouseUp): self
    {
        $self = clone $this;
        $self['leftMouseUp'] = $leftMouseUp;

        return $self;
    }

    /**
     * ``list_tabs``'s config overrides.
     *
     * @param ListTabs|ListTabsShape|null $listTabs
     */
    public function withListTabs(ListTabs|array|null $listTabs): self
    {
        $self = clone $this;
        $self['listTabs'] = $listTabs;

        return $self;
    }

    /**
     * ``middle_click``'s config overrides.
     *
     * @param MiddleClick|MiddleClickShape|null $middleClick
     */
    public function withMiddleClick(MiddleClick|array|null $middleClick): self
    {
        $self = clone $this;
        $self['middleClick'] = $middleClick;

        return $self;
    }

    /**
     * ``mouse_move``'s config overrides.
     *
     * @param MouseMove|MouseMoveShape|null $mouseMove
     */
    public function withMouseMove(MouseMove|array|null $mouseMove): self
    {
        $self = clone $this;
        $self['mouseMove'] = $mouseMove;

        return $self;
    }

    /**
     * ``navigate``'s config overrides.
     *
     * @param Navigate|NavigateShape|null $navigate
     */
    public function withNavigate(Navigate|array|null $navigate): self
    {
        $self = clone $this;
        $self['navigate'] = $navigate;

        return $self;
    }

    /**
     * ``new_tab``'s config overrides.
     *
     * @param NewTab|NewTabShape|null $newTab
     */
    public function withNewTab(NewTab|array|null $newTab): self
    {
        $self = clone $this;
        $self['newTab'] = $newTab;

        return $self;
    }

    /**
     * ``read_console``'s config overrides.
     *
     * @param ReadConsole|ReadConsoleShape|null $readConsole
     */
    public function withReadConsole(ReadConsole|array|null $readConsole): self
    {
        $self = clone $this;
        $self['readConsole'] = $readConsole;

        return $self;
    }

    /**
     * ``read_network``'s config overrides.
     *
     * @param ReadNetwork|ReadNetworkShape|null $readNetwork
     */
    public function withReadNetwork(ReadNetwork|array|null $readNetwork): self
    {
        $self = clone $this;
        $self['readNetwork'] = $readNetwork;

        return $self;
    }

    /**
     * ``read_page``'s config overrides.
     *
     * @param ReadPage|ReadPageShape|null $readPage
     */
    public function withReadPage(ReadPage|array|null $readPage): self
    {
        $self = clone $this;
        $self['readPage'] = $readPage;

        return $self;
    }

    /**
     * ``right_click``'s config overrides.
     *
     * @param RightClick|RightClickShape|null $rightClick
     */
    public function withRightClick(RightClick|array|null $rightClick): self
    {
        $self = clone $this;
        $self['rightClick'] = $rightClick;

        return $self;
    }

    /**
     * ``screenshot``'s config overrides.
     *
     * @param Screenshot|ScreenshotShape|null $screenshot
     */
    public function withScreenshot(Screenshot|array|null $screenshot): self
    {
        $self = clone $this;
        $self['screenshot'] = $screenshot;

        return $self;
    }

    /**
     * ``scroll``'s config overrides.
     *
     * @param Scroll|ScrollShape|null $scroll
     */
    public function withScroll(Scroll|array|null $scroll): self
    {
        $self = clone $this;
        $self['scroll'] = $scroll;

        return $self;
    }

    /**
     * ``scroll_to``'s config overrides.
     *
     * @param ScrollTo|ScrollToShape|null $scrollTo
     */
    public function withScrollTo(ScrollTo|array|null $scrollTo): self
    {
        $self = clone $this;
        $self['scrollTo'] = $scrollTo;

        return $self;
    }

    /**
     * ``switch_tab``'s config overrides.
     *
     * @param SwitchTab|SwitchTabShape|null $switchTab
     */
    public function withSwitchTab(SwitchTab|array|null $switchTab): self
    {
        $self = clone $this;
        $self['switchTab'] = $switchTab;

        return $self;
    }

    /**
     * ``triple_click``'s config overrides.
     *
     * @param TripleClick|TripleClickShape|null $tripleClick
     */
    public function withTripleClick(TripleClick|array|null $tripleClick): self
    {
        $self = clone $this;
        $self['tripleClick'] = $tripleClick;

        return $self;
    }

    /**
     * ``type``'s config overrides.
     *
     * @param Type|TypeShape|null $type
     */
    public function withType(Type|array|null $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ``wait``'s config overrides.
     *
     * @param Wait|WaitShape|null $wait
     */
    public function withWait(Wait|array|null $wait): self
    {
        $self = clone $this;
        $self['wait'] = $wait;

        return $self;
    }

    /**
     * ``zoom``'s config overrides.
     *
     * @param Zoom|ZoomShape|null $zoom
     */
    public function withZoom(Zoom|array|null $zoom): self
    {
        $self = clone $this;
        $self['zoom'] = $zoom;

        return $self;
    }
}
