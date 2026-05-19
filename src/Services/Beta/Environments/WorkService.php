<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Environments;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Environments\Work\SelfHostedWork;
use Anthropic\Beta\Environments\Work\SelfHostedWorkHeartbeatResponse;
use Anthropic\Beta\Environments\Work\SelfHostedWorkQueueStats;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Environments\WorkContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class WorkService implements WorkContract
{
    /**
     * @api
     */
    public WorkRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new WorkRawService($client);
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Retrieve detailed information about a specific work item.
     *
     * @param string $workID Path param
     * @param string $environmentID Path param
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function retrieve(
        string $workID,
        string $environmentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SelfHostedWork {
        $params = Util::removeNulls(
            ['environmentID' => $environmentID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->retrieve($workID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Update work item metadata with merge semantics.
     *
     * @param string $workID Path param
     * @param string $environmentID Path param
     * @param array<string,string|null> $metadata Body param: Metadata patch. Set a key to a string to upsert it, or to null to delete it. Omit the field to preserve existing metadata.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $workID,
        string $environmentID,
        array $metadata,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SelfHostedWork {
        $params = Util::removeNulls(
            [
                'environmentID' => $environmentID,
                'metadata' => $metadata,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($workID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * List work items in an environment.
     *
     * @param string $environmentID Path param
     * @param int $limit Query param: Maximum number of work items to return
     * @param string|null $page Query param: Opaque cursor from previous response for pagination
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<SelfHostedWork>
     *
     * @throws APIException
     */
    public function list(
        string $environmentID,
        int $limit = 20,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            ['limit' => $limit, 'page' => $page, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($environmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Acknowledge receipt of a work item, transitioning it from 'queued' to 'starting' and removing it from the queue.
     *
     * @param string $workID Path param
     * @param string $environmentID Path param
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function ack(
        string $workID,
        string $environmentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SelfHostedWork {
        $params = Util::removeNulls(
            ['environmentID' => $environmentID, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->ack($workID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Record a heartbeat for a work item to maintain the lease.
     *
     * @param string $workID Path param
     * @param string $environmentID Path param
     * @param int|null $desiredTTLSeconds Query param: Desired TTL in seconds
     * @param string|null $expectedLastHeartbeat Query param: Expected last_heartbeat for conditional update (optimistic concurrency). Use literal 'NO_HEARTBEAT' to claim an unclaimed lease (first heartbeat). For subsequent heartbeats, echo the server's previous last_heartbeat value exactly. Returns 412 Precondition Failed if the actual value doesn't match.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function heartbeat(
        string $workID,
        string $environmentID,
        ?int $desiredTTLSeconds = null,
        ?string $expectedLastHeartbeat = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SelfHostedWorkHeartbeatResponse {
        $params = Util::removeNulls(
            [
                'environmentID' => $environmentID,
                'desiredTTLSeconds' => $desiredTTLSeconds,
                'expectedLastHeartbeat' => $expectedLastHeartbeat,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->heartbeat($workID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Long poll for work items in the queue.
     *
     * @param string $environmentID Path param
     * @param int|null $blockMs Query param: How long to wait for work to arrive before returning. Must be 1-999 in milliseconds. Defaults to non-blocking (returns immediately if no work is available).
     * @param int|null $reclaimOlderThanMs Query param: Reclaim unacknowledged work items older than this many milliseconds. If omitted, uses the default (5000ms).
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param string $anthropicWorkerID Header param: Unique identifier for the specific worker polling, used to track aggregated environment-level work metrics in Console
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function poll(
        string $environmentID,
        ?int $blockMs = null,
        ?int $reclaimOlderThanMs = null,
        ?array $betas = null,
        ?string $anthropicWorkerID = null,
        RequestOptions|array|null $requestOptions = null,
    ): SelfHostedWork {
        $params = Util::removeNulls(
            [
                'blockMs' => $blockMs,
                'reclaimOlderThanMs' => $reclaimOlderThanMs,
                'betas' => $betas,
                'anthropicWorkerID' => $anthropicWorkerID,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->poll($environmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Get statistics about the work queue for an environment.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function stats(
        string $environmentID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SelfHostedWorkQueueStats {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->stats($environmentID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Note: these endpoints are called automatically by the pre-built environment worker provided in the SDKs and CLI, for orchestrating sessions with self-hosted sandbox environments. They are included here as a reference; you do not need to invoke them directly.
     *
     * Stop a work item, initiating graceful or forced shutdown.
     *
     * @param string $workID Path param
     * @param string $environmentID Path param
     * @param bool $force Body param: If true, immediately stop work without graceful shutdown
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function stop(
        string $workID,
        string $environmentID,
        bool $force = false,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): SelfHostedWork {
        $params = Util::removeNulls(
            ['environmentID' => $environmentID, 'force' => $force, 'betas' => $betas]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->stop($workID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
