<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition;

enum Type: string
{
    case CONTENT_SHA256 = 'content_sha256';
}
