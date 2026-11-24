<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\UserProfiles\Providers;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\UserProfiles\Providers\GoogleRawContract;

final class GoogleRawService implements GoogleRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
