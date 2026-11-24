<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Providers;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\Providers\GoogleContract;
use Anthropic\Services\Beta\Organization\Providers\Google\ProjectsService;

final class GoogleService implements GoogleContract
{
    /**
     * @api
     */
    public GoogleRawService $raw;

    /**
     * @api
     */
    public ProjectsService $projects;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new GoogleRawService($client);
        $this->projects = new ProjectsService($client);
    }
}
