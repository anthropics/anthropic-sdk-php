<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Environments\BetaEnvironment;
use Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;
use Anthropic\Beta\Environments\EnvironmentArchiveParams;
use Anthropic\Beta\Environments\EnvironmentCreateParams;
use Anthropic\Beta\Environments\EnvironmentDeleteParams;
use Anthropic\Beta\Environments\EnvironmentListParams;
use Anthropic\Beta\Environments\EnvironmentRetrieveParams;
use Anthropic\Beta\Environments\EnvironmentUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface EnvironmentsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function create(
        array|EnvironmentCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function retrieve(
        string $environmentID,
        array|EnvironmentRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $environmentID Path param
     * @param array<string,mixed>|EnvironmentUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function update(
        string $environmentID,
        array|EnvironmentUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaEnvironment>>
     *
     * @throws APIException
     */
    public function list(
        array|EnvironmentListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironmentDeleteResponse>
     *
     * @throws APIException
     */
    public function delete(
        string $environmentID,
        array|EnvironmentDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|EnvironmentArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaEnvironment>
     *
     * @throws APIException
     */
    public function archive(
        string $environmentID,
        array|EnvironmentArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
