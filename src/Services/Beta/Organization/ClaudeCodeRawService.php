<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCodeRawContract;

final class ClaudeCodeRawService implements ClaudeCodeRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
