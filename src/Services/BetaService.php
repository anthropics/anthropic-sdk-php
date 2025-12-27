<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\Client;
use Anthropic\ServiceContracts\BetaContract;
use Anthropic\Services\Beta\FilesService;
use Anthropic\Services\Beta\MessagesService;
use Anthropic\Services\Beta\ModelsService;
use Anthropic\Services\Beta\SkillsService;

final class BetaService implements BetaContract
{
    /**
     * @api
     */
    public BetaRawService $raw;

    /**
     * @api
     */
    public ModelsService $models;

    /**
     * @api
     */
    public MessagesService $messages;

    /**
     * @api
     */
    public FilesService $files;

    /**
     * @api
     */
    public SkillsService $skills;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new BetaRawService($client);
        $this->models = new ModelsService($client);
        $this->messages = new MessagesService($client);
        $this->files = new FilesService($client);
        $this->skills = new SkillsService($client);
    }
}
