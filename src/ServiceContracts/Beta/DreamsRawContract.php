<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Dreams\BetaDream;
use Anthropic\Beta\Dreams\DreamArchiveParams;
use Anthropic\Beta\Dreams\DreamCancelParams;
use Anthropic\Beta\Dreams\DreamCreateParams;
use Anthropic\Beta\Dreams\DreamListParams;
use Anthropic\Beta\Dreams\DreamRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface DreamsRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|DreamCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function create(
        array|DreamCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $dreamID Path parameter dream_id
     * @param array<string,mixed>|DreamRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function retrieve(
        string $dreamID,
        array|DreamRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|DreamListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<BetaDream>>
     *
     * @throws APIException
     */
    public function list(
        array|DreamListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $dreamID Path parameter dream_id
     * @param array<string,mixed>|DreamArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function archive(
        string $dreamID,
        array|DreamArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $dreamID Path parameter dream_id
     * @param array<string,mixed>|DreamCancelParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaDream>
     *
     * @throws APIException
     */
    public function cancel(
        string $dreamID,
        array|DreamCancelParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
