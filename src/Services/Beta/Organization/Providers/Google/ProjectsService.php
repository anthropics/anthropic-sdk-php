<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Providers\Google;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\Providers\Google\ProjectsContract;
use Anthropic\Services\Beta\Organization\Providers\Google\Projects\DataControlsService;

final class ProjectsService implements ProjectsContract
{
    /**
     * @api
     */
    public ProjectsRawService $raw;

    /**
     * @api
     */
    public DataControlsService $dataControls;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ProjectsRawService($client);
        $this->dataControls = new DataControlsService($client);
    }
}
