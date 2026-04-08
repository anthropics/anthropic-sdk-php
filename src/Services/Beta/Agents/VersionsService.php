<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
use Anthropic\Beta\AnthropicBeta;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Agents\VersionsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class VersionsService implements VersionsContract
{
    /**
     * @api
     */
    public VersionsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new VersionsRawService($client);
    }

    /**
     * @api
     *
     * List Agent Versions
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param int $limit Query param: Maximum results per page. Default 20, maximum 100.
     * @param string $page query param: Opaque pagination cursor
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaManagedAgentsAgent>
     *
     * @throws APIException
     */
    public function list(
        string $agentID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($agentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
