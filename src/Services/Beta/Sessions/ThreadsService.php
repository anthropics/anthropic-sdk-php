<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Sessions\ThreadsContract;
use Anthropic\Services\Beta\Sessions\Threads\EventsService;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ThreadsService implements ThreadsContract
{
    /**
     * @api
     */
    public ThreadsRawService $raw;

    /**
     * @api
     */
    public EventsService $events;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new ThreadsRawService($client);
        $this->events = new EventsService($client);
    }

    /**
     * @api
     *
     * Get Session Thread
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param string $sessionID Path param: Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $threadID,
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsSessionThread {
        $params = Util::removeNulls(['sessionID' => $sessionID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($threadID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * List Session Threads
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param int $limit Query param: Maximum results per page. Defaults to 1000.
     * @param string $page Query param: Opaque pagination cursor from a previous response's next_page. Forward-only.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsSessionThread>
     *
     * @throws APIException
     */
    public function list(
        string $sessionID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($sessionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Archive Session Thread
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param string $sessionID Path param: Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function archive(
        string $threadID,
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsSessionThread {
        $params = Util::removeNulls(['sessionID' => $sessionID, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->archive($threadID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
