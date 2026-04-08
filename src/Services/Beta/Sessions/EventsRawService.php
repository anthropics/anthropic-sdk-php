<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Events\EventListParams;
use Anthropic\Beta\Sessions\Events\EventListParams\Order;
use Anthropic\Beta\Sessions\Events\EventSendParams;
use Anthropic\Beta\Sessions\Events\EventStreamParams;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentCustomToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThinkingEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadContextCompactedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionDeletedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRescheduledEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRunningEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusTerminatedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsStreamSessionEvents;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Sessions\EventsRawContract;
use Anthropic\SSEStream;

/**
 * @phpstan-import-type ManagedAgentsEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsEventParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class EventsRawService implements EventsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * List Events
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array{
     *   limit?: int,
     *   order?: Order|value-of<Order>,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|EventListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSessionDeletedEvent,>,>
     *
     * @throws APIException
     */
    public function list(
        string $sessionID,
        array|EventListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EventListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(['limit', 'order', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sessions/%1$s/events?beta=true', $sessionID],
            query: array_intersect_key($parsed, $query_params),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsSessionEvent::class,
            page: PageCursor::class,
        );
    }

    /**
     * @api
     *
     * Send Events
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param array{
     *   events: list<ManagedAgentsEventParamsShape>,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|EventSendParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ManagedAgentsSendSessionEvents>
     *
     * @throws APIException
     */
    public function send(
        string $sessionID,
        array|EventSendParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EventSendParams::parseRequest(
            $params,
            $requestOptions,
        );
        $header_params = ['betas' => 'anthropic-beta'];

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: ['v1/sessions/%1$s/events?beta=true', $sessionID],
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsSendSessionEvents::class,
        );
    }

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param array{
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|EventStreamParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSessionDeletedEvent,>,>
     *
     * @throws APIException
     */
    public function streamStream(
        string $sessionID,
        array|EventStreamParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EventStreamParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/sessions/%1$s/events/stream?beta=true', $sessionID],
            headers: Util::array_transform_keys(
                ['Accept' => 'text/event-stream', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsStreamSessionEvents::class,
            stream: SSEStream::class,
        );
    }
}
