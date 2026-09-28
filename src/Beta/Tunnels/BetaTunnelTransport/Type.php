<?php

declare(strict_types=1);

namespace Anthropic\Beta\Tunnels\BetaTunnelTransport;

enum Type: string
{
    case CLOUDFLARE = 'cloudflare';

    case RELAY = 'relay';
}
