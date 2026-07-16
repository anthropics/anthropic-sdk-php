<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\ServiceContracts\BetaContract;
use Anthropic\Services\Beta\AgentsService;
use Anthropic\Services\Beta\DeploymentRunsService;
use Anthropic\Services\Beta\DeploymentsService;
use Anthropic\Services\Beta\DreamsService;
use Anthropic\Services\Beta\EnvironmentsService;
use Anthropic\Services\Beta\FilesService;
use Anthropic\Services\Beta\MemoryStoresService;
use Anthropic\Services\Beta\MessagesService;
use Anthropic\Services\Beta\ModelsService;
use Anthropic\Services\Beta\SessionsService;
use Anthropic\Services\Beta\SkillsService;
use Anthropic\Services\Beta\TunnelsService;
use Anthropic\Services\Beta\UserProfilesService;
use Anthropic\Services\Beta\VaultsService;
use Anthropic\Services\Beta\WebhooksService;

final class BetaService implements BetaContract
{
    /**
     * @api
     */
    public BetaRawService $raw;

    /**
     * @api
     */
    public ModelsService $models;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @api
     */
    public AgentsService $agents;

    /**
     * @api
     */
    public EnvironmentsService $environments;

    /**
     * @api
     */
    public SessionsService $sessions;

    /**
     * @api
     */
    public DeploymentsService $deployments;

    /**
     * @api
     */
    public DeploymentRunsService $deploymentRuns;

    /**
     * @api
     */
    public VaultsService $vaults;

    /**
     * @api
     */
    public MemoryStoresService $memoryStores;

    /**
     * @api
     */
    public FilesService $files;

    /**
     * @api
     */
    public SkillsService $skills;

    /**
     * @api
     */
    public WebhooksService $webhooks;

    /**
     * @api
     */
    public UserProfilesService $userProfiles;

    /**
     * @api
     */
    public DreamsService $dreams;

    /**
     * @api
     */
    public TunnelsService $tunnels;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BetaRawService($client);
        $this->models = new ModelsService($client);
        $this->messages = new MessagesService($client);
        $this->agents = new AgentsService($client);
        $this->environments = new EnvironmentsService($client);
        $this->sessions = new SessionsService($client);
        $this->deployments = new DeploymentsService($client);
        $this->deploymentRuns = new DeploymentRunsService($client);
        $this->vaults = new VaultsService($client);
        $this->memoryStores = new MemoryStoresService($client);
        $this->files = new FilesService($client);
        $this->skills = new SkillsService($client);
        $this->webhooks = new WebhooksService($client);
        $this->userProfiles = new UserProfilesService($client);
        $this->dreams = new DreamsService($client);
        $this->tunnels = new TunnelsService($client);
    }
}
