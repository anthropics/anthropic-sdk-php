<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Environments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\Work\SelfHostedWork;
use Anthropic\Beta\Environments\Work\SelfHostedWorkHeartbeatResponse;
use Anthropic\Beta\Environments\Work\SelfHostedWorkQueueStats;
use Anthropic\Beta\Environments\Work\WorkAckParams;
use Anthropic\Beta\Environments\Work\WorkHeartbeatParams;
use Anthropic\Beta\Environments\Work\WorkListParams;
use Anthropic\Beta\Environments\Work\WorkPollParams;
use Anthropic\Beta\Environments\Work\WorkRetrieveParams;
use Anthropic\Beta\Environments\Work\WorkStatsParams;
use Anthropic\Beta\Environments\Work\WorkStopParams;
use Anthropic\Beta\Environments\Work\WorkUpdateParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Environments\WorkRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WorkRawService implements WorkRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Retrieve detailed information about a specific work item.
     *
     * @param string $workID Path param
     * @param array{
     *   environmentID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkRetrieveParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws APIException
     */
    public function retrieve(
        string $workID,
        array|WorkRetrieveParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkRetrieveParams::parseRequest(
            $params,
            $requestOptions,
        );
        $environmentID = $parsed['environmentID'];
        unset($parsed['environmentID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/environments/%1$s/work/%2$s?beta=true', $environmentID, $workID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWork::class,
        );
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Update work item metadata with merge semantics.
     *
     * @param string $workID Path param
     * @param array{
     *   environmentID: string,
     *   metadata: array<string,string|null>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws APIException
     */
    public function update(
        string $workID,
        array|WorkUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $environmentID = $parsed['environmentID'];
        unset($parsed['environmentID']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/environments/%1$s/work/%2$s?beta=true', $environmentID, $workID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['environmentID']),
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWork::class,
        );
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * List work items in an environment.
     *
     * @param string $environmentID Path param
     * @param array{
     *   limit?: int,
     *   page?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<SelfHostedWork>>
     *
     * @throws APIException
     */
    public function list(
        string $environmentID,
        array|WorkListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/environments/%1$s/work?beta=true', $environmentID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWork::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Acknowledge receipt of a work item, transitioning it from 'queued' to 'starting' and removing it from the queue.
     *
     * @param string $workID Path param
     * @param array{
     *   environmentID: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkAckParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws APIException
     */
    public function ack(
        string $workID,
        array|WorkAckParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkAckParams::parseRequest(
            $params,
            $requestOptions,
        );
        $environmentID = $parsed['environmentID'];
        unset($parsed['environmentID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/environments/%1$s/work/%2$s/ack?beta=true', $environmentID, $workID,
            ],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWork::class,
        );
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Record a heartbeat for a work item to maintain the lease.
     *
     * @param string $workID Path param
     * @param array{
     *   environmentID: string,
     *   desiredTTLSeconds?: int|null,
     *   expectedLastHeartbeat?: string|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkHeartbeatParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWorkHeartbeatResponse>
     *
     * @throws APIException
     */
    public function heartbeat(
        string $workID,
        array|WorkHeartbeatParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkHeartbeatParams::parseRequest(
            $params,
            $requestOptions,
        );
        $environmentID = $parsed['environmentID'];
        unset($parsed['environmentID']);
        $query_params = array_flip(['desiredTTLSeconds', 'expectedLastHeartbeat']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/environments/%1$s/work/%2$s/heartbeat?beta=true',
                $environmentID,
                $workID,
            ],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'desiredTTLSeconds' => 'desired_ttl_seconds',
                    'expectedLastHeartbeat' => 'expected_last_heartbeat',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWorkHeartbeatResponse::class,
        );
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Long poll for work items in the queue.
     *
     * @param string $environmentID Path param
     * @param array{
     *   blockMs?: int|null,
     *   reclaimOlderThanMs?: int|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     *   anthropicWorkerID?: string,
     * }|WorkPollParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws APIException
     */
    public function poll(
        string $environmentID,
        array|WorkPollParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkPollParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['blockMs', 'reclaimOlderThanMs']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/environments/%1$s/work/poll?beta=true', $environmentID],
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'blockMs' => 'block_ms',
                    'reclaimOlderThanMs' => 'reclaim_older_than_ms',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                [
                    'betas' => 'anthropic-beta',
                    'anthropicWorkerID' => 'Anthropic-Worker-ID',
                ],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWork::class,
        );
    }

    /**
     * @api
     *
     * Get statistics about the work queue for an environment.
     *
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|WorkStatsParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWorkQueueStats>
     *
     * @throws APIException
     */
    public function stats(
        string $environmentID,
        array|WorkStatsParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkStatsParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/environments/%1$s/work/stats?beta=true', $environmentID],
            headers: Util::array_transform_keys(
                $parsed,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWorkQueueStats::class,
        );
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Stop a work item, initiating graceful or forced shutdown.
     *
     * @param string $workID Path param
     * @param array{
     *   environmentID: string,
     *   force?: bool,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|WorkStopParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<SelfHostedWork>
     *
     * @throws APIException
     */
    public function stop(
        string $workID,
        array|WorkStopParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = WorkStopParams::parseRequest(
            $params,
            $requestOptions,
        );
        $environmentID = $parsed['environmentID'];
        unset($parsed['environmentID']);
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/environments/%1$s/work/%2$s/stop?beta=true', $environmentID, $workID,
            ],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                array_diff_key($parsed, array_flip(array_keys($header_params))),
                array_flip(['environmentID']),
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: SelfHostedWork::class,
        );
    }
}
