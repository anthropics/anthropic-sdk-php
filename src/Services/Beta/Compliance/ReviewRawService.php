<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Compliance;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Compliance\ReviewRawContract;

final class ReviewRawService implements ReviewRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
