<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\ClaudeTagContract;
use Anthropic\Services\Beta\Organization\ClaudeTag\BundlesService;
use Anthropic\Services\Beta\Organization\ClaudeTag\SlackChannelsService;
use Anthropic\Services\Beta\Organization\ClaudeTag\SlackWorkspacesService;

final class ClaudeTagService implements ClaudeTagContract
{
    /**
     * @api
     */
    public ClaudeTagRawService $raw;

    /**
     * @api
     */
    public SlackChannelsService $slackChannels;

    /**
     * @api
     */
    public SlackWorkspacesService $slackWorkspaces;

    /**
     * @api
     */
    public BundlesService $bundles;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ClaudeTagRawService($client);
        $this->slackChannels = new SlackChannelsService($client);
        $this->slackWorkspaces = new SlackWorkspacesService($client);
        $this->bundles = new BundlesService($client);
    }
}
