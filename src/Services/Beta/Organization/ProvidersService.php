<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\ProvidersContract;
use Anthropic\Services\Beta\Organization\Providers\GoogleService;

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
