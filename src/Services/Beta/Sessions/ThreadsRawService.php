<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread;
use Anthropic\Beta\Sessions\Threads\ThreadArchiveParams;
use Anthropic\Beta\Sessions\Threads\ThreadListParams;
use Anthropic\Beta\Sessions\Threads\ThreadRetrieveParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Sessions\ThreadsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ThreadsRawService implements ThreadsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get Session Thread
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param array{
     *   sessionID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ThreadRetrieveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ThreadRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $sessionID = $parsed['sessionID'];
        unset($parsed['sessionID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sessions/%1$s/threads/%2$s?beta=true', $sessionID, $threadID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsSessionThread::class,
        );
    }

    /**
     * @api
     *
     * List Session Threads
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array{
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|ThreadListParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ThreadListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sessions/%1$s/threads?beta=true', $sessionID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsSessionThread::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Archive Session Thread
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param array{
     *   sessionID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|ThreadArchiveParams $params
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
    ): BaseResponse {
        [$parsed, $options] = ThreadArchiveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $sessionID = $parsed['sessionID'];
        unset($parsed['sessionID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/sessions/%1$s/threads/%2$s/archive?beta=true', $sessionID, $threadID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsSessionThread::class,
        );
    }
}
