<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Beta\Files\FilesService;
use Anthropic\Beta\Messages\MessagesService;
use Anthropic\Beta\Models\ModelsService;
use Anthropic\Client;
use Anthropic\Contracts\BetaContract;

final class BetaService implements BetaContract
{
    public ModelsService $models;

    public MessagesService $messages;

    public FilesService $files;

    public function __construct(private Client $client)
    {
        $this->models = new ModelsService($this->client);
        $this->messages = new MessagesService($this->client);
        $this->files = new FilesService($this->client);
    }
}
