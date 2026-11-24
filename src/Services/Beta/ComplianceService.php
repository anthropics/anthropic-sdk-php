<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\ComplianceContract;
use Anthropic\Services\Beta\Compliance\ReviewService;

final class ComplianceService implements ComplianceContract
{
    /**
     * @api
     */
    public ComplianceRawService $raw;

    /**
     * @api
     */
    public ReviewService $review;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ComplianceRawService($client);
        $this->review = new ReviewService($client);
    }
}
