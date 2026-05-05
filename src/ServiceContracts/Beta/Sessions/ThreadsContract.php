<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ThreadsContract
{
    /**
     * @api
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
    ): ManagedAgentsSessionThread;

    /**
     * @api
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
    ): PageCursor;

    /**
     * @api
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
    ): ManagedAgentsSessionThread;
}
