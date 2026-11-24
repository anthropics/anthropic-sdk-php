<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Compliance;

use Anthropic\Client;
use Anthropic\ServiceContracts\Beta\Compliance\ReviewContract;
use Anthropic\Services\Beta\Compliance\Review\CasesService;
use Anthropic\Services\Beta\Compliance\Review\ItemsService;
use Anthropic\Services\Beta\Compliance\Review\NoticesService;

final class ReviewService implements ReviewContract
{
    /**
     * @api
     */
    public ReviewRawService $raw;

    /**
     * @api
     */
    public CasesService $cases;

    /**
     * @api
     */
    public NoticesService $notices;

    /**
     * @api
     */
    public ItemsService $items;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ReviewRawService($client);
        $this->cases = new CasesService($client);
        $this->notices = new NoticesService($client);
        $this->items = new ItemsService($client);
    }
}
