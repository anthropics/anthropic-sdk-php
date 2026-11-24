<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Providers\Google;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\Providers\Google\ProjectsRawContract;

final class ProjectsRawService implements ProjectsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
