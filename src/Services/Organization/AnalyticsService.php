<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Organization\AnalyticsContract;
use Anthropic\Services\Organization\Analytics\AppsService;
use Anthropic\Services\Organization\Analytics\ArtifactsService;
use Anthropic\Services\Organization\Analytics\ConnectorsService;
use Anthropic\Services\Organization\Analytics\PluginsService;
use Anthropic\Services\Organization\Analytics\SkillsService;
use Anthropic\Services\Organization\Analytics\SummariesService;
use Anthropic\Services\Organization\Analytics\UsersService;

final class AnalyticsService implements AnalyticsContract
{
    /**
     * @api
     */
    public AnalyticsRawService $raw;

    /**
     * @api
     */
    public SummariesService $summaries;

    /**
     * @api
     */
    public UsersService $users;

    /**
     * @api
     */
    public AppsService $apps;

    /**
     * @api
     */
    public ConnectorsService $connectors;

    /**
     * @api
     */
    public PluginsService $plugins;

    /**
     * @api
     */
    public SkillsService $skills;

    /**
     * @api
     */
    public ArtifactsService $artifacts;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AnalyticsRawService($client);
        $this->summaries = new SummariesService($client);
        $this->users = new UsersService($client);
        $this->apps = new AppsService($client);
        $this->connectors = new ConnectorsService($client);
        $this->plugins = new PluginsService($client);
        $this->skills = new SkillsService($client);
        $this->artifacts = new ArtifactsService($client);
    }
}
