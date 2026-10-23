<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\TelemetryDestinations\DeletedTelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationCreateParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDeleteParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationListParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationRetrieveParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestResponse;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTracesParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\TelemetryDestinationsRawContract;

/**
 * @phpstan-import-type TelemetryDestinationWorkspacesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationWorkspacesParams
 * @phpstan-import-type TelemetryDestinationTracesParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTracesParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type TelemetryDestinationStateParamsShape from \Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationStateParams
 */
final class TelemetryDestinationsRawService implements TelemetryDestinationsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Register an OpenTelemetry destination for the organization.
     *
     * The destination starts in state `enabled`. An organization can have at most 10 destinations, including disabled ones.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#add-a-destination) to learn more about adding a destination.
     *
     * @param array{
     *   endpointURL: string,
     *   workspaces: TelemetryDestinationWorkspacesParamsShape,
     *   displayName?: string|null,
     *   headers?: array<string,string>,
     *   traces?: TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TelemetryDestinationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TelemetryDestination>
     *
     * @throws APIException
     */
    public function create(
        array|TelemetryDestinationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TelemetryDestinationCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/organizations/telemetry_destinations',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'telemetry-destinations-2026-08-11',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.create',
                route: '/v1/organizations/telemetry_destinations',
                createdId: 'anthropic.organization.telemetry_destination.id',
            )),
            convert: TelemetryDestination::class,
        );
    }

    /**
     * @api
     *
     * Read a destination's configuration, state, and most recent delivery results.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-and-health) to learn how the API delivers spans and when it disables a destination.
     *
     * @param string $destinationID ID of the destination (`tdst_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TelemetryDestinationRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TelemetryDestination>
     *
     * @throws APIException
     */
    public function retrieve(
        string $destinationID,
        array|TelemetryDestinationRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TelemetryDestinationRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/telemetry_destinations/%1$s', $destinationID],
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
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.retrieve',
                route: '/v1/organizations/telemetry_destinations/{destination_id}',
                attributes: [
                    'anthropic.organization.telemetry_destination.id' => $destinationID,
                ],
            )),
            convert: TelemetryDestination::class,
        );
    }

    /**
     * @api
     *
     * Change a telemetry destination's settings, its state, or which workspaces it covers.
     *
     * Send at least one field. Omitted fields keep their stored values, except the registered headers, which a change of the endpoint's hostname or port removes. Only `display_name`, `traces`, `traces.endpoint_url`, `traces.content_mode`, `traces.max_content_bytes`, and individual `headers` values accept `null`.
     *
     * If another request changes the destination while the update runs, the API returns a 409 `conflict_error`. Read the destination again, then retry the update.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-and-health) to learn more about changing a destination.
     *
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param array{
     *   displayName?: string|null,
     *   endpointURL?: string,
     *   headers?: array<string,string|null>|null,
     *   state?: TelemetryDestinationStateParamsShape,
     *   traces?: TelemetryDestinationTracesParams|TelemetryDestinationTracesParamsShape|null,
     *   workspaces?: TelemetryDestinationWorkspacesParamsShape,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TelemetryDestinationUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TelemetryDestination>
     *
     * @throws APIException
     */
    public function update(
        string $destinationID,
        array|TelemetryDestinationUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TelemetryDestinationUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/organizations/telemetry_destinations/%1$s', $destinationID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'telemetry-destinations-2026-08-11',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.update',
                route: '/v1/organizations/telemetry_destinations/{destination_id}',
                attributes: [
                    'anthropic.organization.telemetry_destination.id' => $destinationID,
                ],
            )),
            convert: TelemetryDestination::class,
        );
    }

    /**
     * @api
     *
     * List the organization's destinations, newest first, optionally only those that cover given workspaces.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#set-up-api-tracing) to learn more about destinations.
     *
     * @param array{
     *   limit?: int,
     *   page?: string,
     *   workspaceIDs?: list<string>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|TelemetryDestinationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<TelemetryDestination>>
     *
     * @throws APIException
     */
    public function list(
        array|TelemetryDestinationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TelemetryDestinationListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page', 'workspaceIDs']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/telemetry_destinations',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                ['workspaceIDs' => 'workspace_ids'],
            ),
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
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.list',
                route: '/v1/organizations/telemetry_destinations',
                query: ['limit', 'page', 'workspace_ids'],
            )),
            convert: TelemetryDestination::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Delete a destination and its workspace list.
     *
     * The API stops sending spans to the destination. The spans of the workspaces it covered still go to the other destinations that cover them. A deleted destination can't be read, listed, or restored.
     *
     * See the [OpenTelemetry export guide](https://platform.claude.com/docs/en/manage-claude/opentelemetry#delivery-and-health) to learn more about managing a destination.
     *
     * @param string $destinationID ID of the destination (`tdst_...`).
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TelemetryDestinationDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<DeletedTelemetryDestination>
     *
     * @throws APIException
     */
    public function delete(
        string $destinationID,
        array|TelemetryDestinationDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TelemetryDestinationDeleteParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'delete',
            path: ['v1/organizations/telemetry_destinations/%1$s', $destinationID],
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
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.delete',
                route: '/v1/organizations/telemetry_destinations/{destination_id}',
                attributes: [
                    'anthropic.organization.telemetry_destination.id' => $destinationID,
                ],
            )),
            convert: DeletedTelemetryDestination::class,
        );
    }

    /**
     * @api
     *
     * Send one test span, named `anthropic.test`, to the destination with its registered headers, once and without retries, and report the destination's answer. The response is 200 whether or not the destination answered with a 2xx status: its `result` has the type `success`, or the type `failure` and the reason in `error`. The destination's configuration, `state` and `delivery_health` do not change. A disabled destination can be tested too. Wait 10 seconds between tests of one destination; a request that comes sooner may be answered with status 429.
     *
     * @param string $destinationID ID of the destination to test (starts with `tdst_`)
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|TelemetryDestinationTestParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TelemetryDestinationTestResponse>
     *
     * @throws APIException
     */
    public function test(
        string $destinationID,
        array|TelemetryDestinationTestParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = TelemetryDestinationTestParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/telemetry_destinations/%1$s/test', $destinationID,
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
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.telemetry_destinations.test',
                route: '/v1/organizations/telemetry_destinations/{destination_id}/test',
                attributes: [
                    'anthropic.organization.telemetry_destination.id' => $destinationID,
                ],
            )),
            convert: TelemetryDestinationTestResponse::class,
        );
    }
}
