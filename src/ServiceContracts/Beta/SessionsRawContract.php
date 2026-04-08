<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Sessions\BetaManagedAgentsDeletedSession;
use Anthropic\Beta\Sessions\BetaManagedAgentsSession;
use Anthropic\Beta\Sessions\SessionArchiveParams;
use Anthropic\Beta\Sessions\SessionCreateParams;
use Anthropic\Beta\Sessions\SessionDeleteParams;
use Anthropic\Beta\Sessions\SessionListParams;
use Anthropic\Beta\Sessions\SessionRetrieveParams;
use Anthropic\Beta\Sessions\SessionUpdateParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface SessionsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|SessionCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function create(
        array|SessionCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param array<string,mixed>|SessionRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function retrieve(
        string $sessionID,
        array|SessionRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array<string,mixed>|SessionUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function update(
        string $sessionID,
        array|SessionUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|SessionListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaManagedAgentsSession>>
     *
     * @throws APIException
     */
    public function list(
        array|SessionListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param array<string,mixed>|SessionDeleteParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsDeletedSession>
     *
     * @throws APIException
     */
    public function delete(
        string $sessionID,
        array|SessionDeleteParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param array<string,mixed>|SessionArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaManagedAgentsSession>
     *
     * @throws APIException
     */
    public function archive(
        string $sessionID,
        array|SessionArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
