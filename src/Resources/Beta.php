<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\BetaContract;
use Anthropic\Resources\Beta\Files;
use Anthropic\Resources\Beta\Messages;
use Anthropic\Resources\Beta\Models;

class Beta implements BetaContract
{
    public Models $models;

    public Messages $messages;

    public Files $files;

    public function __construct(protected Client $client)
    {
        $this->models = new Models($client);
        $this->messages = new Messages($client);
        $this->files = new Files($client);
    }
}
