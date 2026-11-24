<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\ProvidersRawContract;

final class ProvidersRawService implements ProvidersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
