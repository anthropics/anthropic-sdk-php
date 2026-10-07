<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaBrowserToolUseBlock;

enum Name: string
{
    case NAVIGATE = 'navigate';

    case LIST_TABS = 'list_tabs';

    case NEW_TAB = 'new_tab';

    case SWITCH_TAB = 'switch_tab';

    case CLOSE_TAB = 'close_tab';

    case READ_PAGE = 'read_page';

    case GET_PAGE_TEXT = 'get_page_text';

    case READ_CONSOLE = 'read_console';

    case READ_NETWORK = 'read_network';

    case FIND = 'find';

    case FORM_INPUT = 'form_input';

    case FILE_UPLOAD = 'file_upload';

    case SCROLL_TO = 'scroll_to';

    case SCREENSHOT = 'screenshot';

    case ZOOM = 'zoom';

    case LEFT_CLICK = 'left_click';

    case RIGHT_CLICK = 'right_click';

    case MIDDLE_CLICK = 'middle_click';

    case DOUBLE_CLICK = 'double_click';

    case TRIPLE_CLICK = 'triple_click';

    case HOVER = 'hover';

    case LEFT_CLICK_DRAG = 'left_click_drag';

    case LEFT_MOUSE_DOWN = 'left_mouse_down';

    case LEFT_MOUSE_UP = 'left_mouse_up';

    case MOUSE_MOVE = 'mouse_move';

    case SCROLL = 'scroll';

    case TYPE = 'type';

    case KEY = 'key';

    case HOLD_KEY = 'hold_key';

    case WAIT = 'wait';

    case JAVASCRIPT_EXEC = 'javascript_exec';
}
