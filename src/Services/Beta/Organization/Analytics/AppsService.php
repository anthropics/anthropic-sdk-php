<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\AppsContract;
use Anthropic\Services\Beta\Organization\Analytics\Apps\ChatService;

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
