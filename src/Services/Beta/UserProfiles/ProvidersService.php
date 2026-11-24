<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\UserProfiles;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\UserProfiles\ProvidersContract;
use Anthropic\Services\Beta\UserProfiles\Providers\GoogleService;

final class ProvidersService implements ProvidersContract
{
    /**
     * @api
     */
    public ProvidersRawService $raw;

    /**
     * @api
     */
    public GoogleService $google;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ProvidersRawService($client);
        $this->google = new GoogleService($client);
    }
}
