<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\BetaContract;
use Anthropic\Resources\Beta\Files;
use Anthropic\Resources\Beta\Messages;
use Anthropic\Resources\Beta\Models;

final class Beta implements BetaContract
{
    public Models $models;

    public Messages $messages;

    public Files $files;

    public function __construct(private Client $client)
    {
        $this->models = new Models($this->client);
        $this->messages = new Messages($this->client);
        $this->files = new Files($this->client);
    }
}
