<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\TelemetryDestinations\DeletedTelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestination;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationCreateParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationDeleteParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationListParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationRetrieveParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestParams;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationTestResponse;
use Anthropic\Beta\Organization\TelemetryDestinations\TelemetryDestinationUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface TelemetryDestinationsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|TelemetryDestinationCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<TelemetryDestination>
     *
     * @throws APIException
     */
    public function create(
        array|TelemetryDestinationCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $destinationID ID of the destination (`tdst_...`).
     * @param array<string,mixed>|TelemetryDestinationRetrieveParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $destinationID Path param: ID of the destination (`tdst_...`).
     * @param array<string,mixed>|TelemetryDestinationUpdateParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|TelemetryDestinationListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<TelemetryDestination>>
     *
     * @throws APIException
     */
    public function list(
        array|TelemetryDestinationListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $destinationID ID of the destination (`tdst_...`).
     * @param array<string,mixed>|TelemetryDestinationDeleteParams $params
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $destinationID ID of the destination to test (starts with `tdst_`)
     * @param array<string,mixed>|TelemetryDestinationTestParams $params
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
    ): BaseResponse;
}
