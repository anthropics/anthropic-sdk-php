<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\ServiceContracts\BetaContract;
use Anthropic\Services\Beta\FilesService;
use Anthropic\Services\Beta\MessagesService;
use Anthropic\Services\Beta\ModelsService;

final class BetaService implements BetaContract
{
    /**
     * @@api
     */
    public ModelsService $models;

    /**
     * @@api
     */
    public MessagesService $messages;

    /**
     * @@api
     */
    public FilesService $files;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->models = new ModelsService($this->client);
        $this->messages = new MessagesService($this->client);
        $this->files = new FilesService($this->client);
    }
}
