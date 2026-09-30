<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\AppsRawContract;

final class AppsRawService implements AppsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
