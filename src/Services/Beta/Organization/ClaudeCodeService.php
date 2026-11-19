<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCodeContract;
use Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettingsService;

final class ClaudeCodeService implements ClaudeCodeContract
{
    /**
     * @api
     */
    public ClaudeCodeRawService $raw;

    /**
     * @api
     */
    public ManagedSettingsService $managedSettings;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ClaudeCodeRawService($client);
        $this->managedSettings = new ManagedSettingsService($client);
    }
}
