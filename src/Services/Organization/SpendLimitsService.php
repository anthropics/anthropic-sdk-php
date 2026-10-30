<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Organization\SpendLimitsContract;
use Anthropic\Services\Organization\SpendLimits\EffectiveService;
use Anthropic\Services\Organization\SpendLimits\IncreaseRequestsService;

final class SpendLimitsService implements SpendLimitsContract
{
    /**
     * @api
     */
    public SpendLimitsRawService $raw;

    /**
     * @api
     */
    public EffectiveService $effective;

    /**
     * @api
     */
    public IncreaseRequestsService $increaseRequests;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SpendLimitsRawService($client);
        $this->effective = new EffectiveService($client);
        $this->increaseRequests = new IncreaseRequestsService($client);
    }
}
