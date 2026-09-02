<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent;
use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface VersionsContract
{
    /**
     * @api
     *
     * @param string $agentID Path param: Path parameter agent_id
     * @param int $limit Query param: Maximum results per page. Default 20, maximum 100.
     * @param string $page query param: Opaque pagination cursor
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $workspaceID Header param: Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
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
        ?string $workspaceID = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
