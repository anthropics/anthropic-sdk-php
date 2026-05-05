<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Sessions;

use Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread;
use Anthropic\Beta\Sessions\Threads\ThreadArchiveParams;
use Anthropic\Beta\Sessions\Threads\ThreadListParams;
use Anthropic\Beta\Sessions\Threads\ThreadRetrieveParams;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface ThreadsRawContract
{
    /**
     * @api
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param array<string,mixed>|ThreadRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsSessionThread>
     *
     * @throws APIException
     */
    public function retrieve(
        string $threadID,
        array|ThreadRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array<string,mixed>|ThreadListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ManagedAgentsSessionThread>>
     *
     * @throws APIException
     */
    public function list(
        string $sessionID,
        array|ThreadListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;

    /**
     * @api
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param array<string,mixed>|ThreadArchiveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsSessionThread>
     *
     * @throws APIException
     */
    public function archive(
        string $threadID,
        array|ThreadArchiveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
