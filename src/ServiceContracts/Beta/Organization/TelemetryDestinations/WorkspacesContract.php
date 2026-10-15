<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaDeletedTelemetryDestinationWorkspace;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaTelemetryDestinationWorkspace;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface WorkspacesContract
{
    /**
     * @api
     *
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param int $limit Query param: Number of entries to return per page, between 1 and 1,000. Defaults to 20.
     * @param string $page Query param: Opaque cursor from a previous response's `next_page`. Leave it out to get the first page.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaTelemetryDestinationWorkspace>
     *
     * @throws APIException
     */
    public function list(
        string $destinationID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $workspaceID Path param: ID of the workspace to add (`wrkspc_...`).
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        string $destinationID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaTelemetryDestinationWorkspace;

    /**
     * @api
     *
     * @param string $workspaceID Path param: ID of the workspace to remove (`wrkspc_...`).
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `telemetry-destinations-2026-08-11` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        string $destinationID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BetaDeletedTelemetryDestinationWorkspace;
}
