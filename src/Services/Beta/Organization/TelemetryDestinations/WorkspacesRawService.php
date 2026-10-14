<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\TelemetryDestinations;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaDeletedTelemetryDestinationWorkspace;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\BetaTelemetryDestinationWorkspace;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\WorkspaceAddParams;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\WorkspaceListParams;
use Anthropic\Beta\Organization\TelemetryDestinations\Workspaces\WorkspaceRemoveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\TelemetryDestinations\WorkspacesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WorkspacesRawService implements WorkspacesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List the workspaces on a destination's workspace list, newest entry first.
     *
     * A destination whose `workspaces.type` is `all` doesn't have a list, so its page is empty. The list includes archived workspaces.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#choose-workspaces-for-a-destination) to learn more about choosing the workspaces of a destination.
     *
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param array{
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkspaceListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaTelemetryDestinationWorkspace>>
     *
     * @throws APIException
     */
    public function list(
        string $destinationID,
        array|WorkspaceListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/organizations/telemetry_destinations/%1$s/workspaces?beta=true',
                $destinationID,
            ],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'telemetry-destinations-2026-08-11',
                    ],
                ],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.workspaces.list',
                route: '/v1/organizations/telemetry_destinations/{destination_id}/workspaces',
                query: ['limit', 'page'],
                attributes: [
                    'anthropic.organization.telemetry_destination.id' => $destinationID,
                ],
            )),
            convert: BetaTelemetryDestinationWorkspace::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Add one workspace to a destination's workspace list.
     *
     * Under `include` the workspace's spans start going to the destination. Under `exclude` they stop. A list holds at most 1,000 workspaces.
     *
     * Adding a workspace that is already on the list changes nothing and returns the existing entry. An archived workspace that isn't on the list yet can't be added. A destination whose `workspaces.type` is `all` doesn't have a list, so the API returns 400. To change which workspaces such a destination covers, update its `workspaces`.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#choose-workspaces-for-a-destination) to learn more about choosing the workspaces of a destination.
     *
     * @param string $workspaceID Path param: ID of the workspace to add (`wrkspc_...`).
     * @param array{
     *   destinationID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkspaceAddParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaTelemetryDestinationWorkspace>
     *
     * @throws APIException
     */
    public function add(
        string $workspaceID,
        array|WorkspaceAddParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceAddParams::parseRequest(
            $params,
            $requestOptions,
        );
        $destinationID = $parsed['destinationID'];
        unset($parsed['destinationID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/telemetry_destinations/%1$s/workspaces/%2$s?beta=true',
                $destinationID,
                $workspaceID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'telemetry-destinations-2026-08-11',
                    ],
                ],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.workspaces.add',
                route: '/v1/organizations/telemetry_destinations/{destination_id}/workspaces/{workspace_id}',
                attributes: [
                    'anthropic.organization.telemetry_destination.id' => $destinationID,
                    'anthropic.organization.telemetry_destination.workspace.id' => $workspaceID,
                ],
            )),
            convert: BetaTelemetryDestinationWorkspace::class,
        );
    }

    /**
     * @api
     *
     * Remove one workspace from a destination's workspace list.
     *
     * Under `include` the workspace's spans stop going to the destination. Under `exclude` they start. An archived workspace can be removed too.
     *
     * The API returns 404 when the workspace isn't on the list. A destination whose `workspaces.type` is `all` doesn't have a list, so the API returns 400.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#choose-workspaces-for-a-destination) to learn more about choosing the workspaces of a destination.
     *
     * @param string $workspaceID Path param: ID of the workspace to remove (`wrkspc_...`).
     * @param array{
     *   destinationID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkspaceRemoveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDeletedTelemetryDestinationWorkspace>
     *
     * @throws APIException
     */
    public function remove(
        string $workspaceID,
        array|WorkspaceRemoveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkspaceRemoveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $destinationID = $parsed['destinationID'];
        unset($parsed['destinationID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: [
                'v1/organizations/telemetry_destinations/%1$s/workspaces/%2$s?beta=true',
                $destinationID,
                $workspaceID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'telemetry-destinations-2026-08-11',
                    ],
                ],
                $options,
            )->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.workspaces.remove',
                route: '/v1/organizations/telemetry_destinations/{destination_id}/workspaces/{workspace_id}',
                attributes: [
                    'anthropic.organization.telemetry_destination.id' => $destinationID,
                    'anthropic.organization.telemetry_destination.workspace.id' => $workspaceID,
                ],
            )),
            convert: BetaDeletedTelemetryDestinationWorkspace::class,
        );
    }
}
