<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeCode;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettingsRawContract;

final class ManagedSettingsRawService implements ManagedSettingsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
