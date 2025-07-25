<?php

declare(strict_types=1);

namespace Anthropic\Resources;

use Anthropic\Client;
use Anthropic\Contracts\BetaContract;
use Anthropic\Resources\Beta\Files;
use Anthropic\Resources\Beta\Messages as Messages1;
use Anthropic\Resources\Beta\Models as Models1;

final class Beta implements BetaContract
{
    public Models1 $models;

    public Messages1 $messages;

    public Files $files;

    public function __construct(private Client $client)
    {
        $this->models = new Models1($this->client);
        $this->messages = new Messages1($this->client);
        $this->files = new Files($this->client);
    }
}
