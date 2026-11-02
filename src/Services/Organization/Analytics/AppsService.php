<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Analytics;

use Anthropic\Client;
use Anthropic\ServiceContracts\Organization\Analytics\AppsContract;
use Anthropic\Services\Organization\Analytics\Apps\ChatService;

final class AppsService implements AppsContract
{
    /**
     * @api
     */
    public AppsRawService $raw;

    /**
     * @api
     */
    public ChatService $chat;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new AppsRawService($client);
        $this->chat = new ChatService($client);
    }
}
