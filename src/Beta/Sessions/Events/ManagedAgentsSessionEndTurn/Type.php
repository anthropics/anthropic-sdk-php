<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEndTurn;

enum Type: string
{
    case END_TURN = 'end_turn';
}
