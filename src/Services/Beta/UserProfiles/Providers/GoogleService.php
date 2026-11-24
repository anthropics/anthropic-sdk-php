<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\UserProfiles\Providers;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\UserProfiles\Providers\GoogleContract;
use Anthropic\Services\Beta\UserProfiles\Providers\Google\DataControlsService;

final class GoogleService implements GoogleContract
{
    /**
     * @api
     */
    public GoogleRawService $raw;

    /**
     * @api
     */
    public DataControlsService $dataControls;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new GoogleRawService($client);
        $this->dataControls = new DataControlsService($client);
    }
}
