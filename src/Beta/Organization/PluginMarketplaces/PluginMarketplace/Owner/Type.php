<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace\Owner;

enum Type: string
{
    case ORGANIZATION = 'organization';

    case USER = 'user';
}
