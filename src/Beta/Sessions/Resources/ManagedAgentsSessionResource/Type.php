<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources\ManagedAgentsSessionResource;

enum Type: string
{
    case GITHUB_REPOSITORY = 'github_repository';

    case FILE = 'file';

    case MEMORY_STORE = 'memory_store';
}
