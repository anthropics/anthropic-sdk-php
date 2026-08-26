<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\FederationContract;
use Anthropic\Services\Beta\Organization\Federation\IssuersService;
use Anthropic\Services\Beta\Organization\Federation\RulesService;

final class FederationService implements FederationContract
{
    /**
     * @api
     */
    public FederationRawService $raw;

    /**
     * @api
     */
    public IssuersService $issuers;

    /**
     * @api
     */
    public RulesService $rules;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new FederationRawService($client);
        $this->issuers = new IssuersService($client);
        $this->rules = new RulesService($client);
    }
}
