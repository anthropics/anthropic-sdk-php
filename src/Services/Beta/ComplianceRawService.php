<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\ComplianceRawContract;

final class ComplianceRawService implements ComplianceRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
