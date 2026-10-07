<?php

declare(strict_types=1);

namespace Anthropic\Messages\ComputerToolUseBlock;

enum Name: string
{
    case KEY = 'key';

    case HOLD_KEY = 'hold_key';

    case TYPE = 'type';

    case CURSOR_POSITION = 'cursor_position';

    case MOUSE_MOVE = 'mouse_move';

    case LEFT_MOUSE_DOWN = 'left_mouse_down';

    case LEFT_MOUSE_UP = 'left_mouse_up';

    case LEFT_CLICK = 'left_click';

    case LEFT_CLICK_DRAG = 'left_click_drag';

    case RIGHT_CLICK = 'right_click';

    case MIDDLE_CLICK = 'middle_click';

    case DOUBLE_CLICK = 'double_click';

    case TRIPLE_CLICK = 'triple_click';

    case SCROLL = 'scroll';

    case WAIT = 'wait';

    case SCREENSHOT = 'screenshot';

    case ZOOM = 'zoom';
}
