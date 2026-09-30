<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics\Apps;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\Apps\ChatRawContract;

final class ChatRawService implements ChatRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}
}
