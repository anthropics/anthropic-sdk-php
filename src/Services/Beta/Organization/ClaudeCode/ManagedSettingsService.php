<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\ClaudeCode;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeCode\ManagedSettingsContract;
use Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings\ConfigurationService;
use Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupDefaultService;
use Anthropic\Services\Beta\Organization\ClaudeCode\ManagedSettings\RBACGroupsService;

final class ManagedSettingsService implements ManagedSettingsContract
{
    /**
     * @api
     */
    public ManagedSettingsRawService $raw;

    /**
     * @api
     */
    public ConfigurationService $configuration;

    /**
     * @api
     */
    public RBACGroupsService $rbacGroups;

    /**
     * @api
     */
    public RBACGroupDefaultService $rbacGroupDefault;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ManagedSettingsRawService($client);
        $this->configuration = new ConfigurationService($client);
        $this->rbacGroups = new RBACGroupsService($client);
        $this->rbacGroupDefault = new RBACGroupDefaultService($client);
    }
}
