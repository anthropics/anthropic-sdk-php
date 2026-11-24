<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Providers;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\Providers\GoogleRawContract;

final class GoogleRawService implements GoogleRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
