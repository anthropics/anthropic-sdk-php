<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\SharedContract;

class Shared implements SharedContract
{
    public function __construct(protected Client $client) {}
}
