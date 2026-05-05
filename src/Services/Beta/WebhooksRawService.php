<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\WebhooksRawContract;

final class WebhooksRawService implements WebhooksRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
