<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Sessions\Threads;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentCustomToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThinkingEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadContextCompactedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionDeletedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRescheduledEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRunningEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusTerminatedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadCreatedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusIdleEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRescheduledEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRunningEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusTerminatedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationEndEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationOngoingEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent;
use Anthropic\Beta\Sessions\Threads\Events\EventListParams;
use Anthropic\Beta\Sessions\Threads\Events\EventStreamParams;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsStreamSessionThreadEvents;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Sessions\Threads\EventsRawContract;
use Anthropic\SSEStream;

/**
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
     * List Session Thread Events
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param array{
     *   sessionID: string,
     *   limit?: int,
     *   page?: string,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|EventListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|ManagedAgentsSessionThreadStatusRescheduledEvent,>,>
     *
     * @throws APIException
     */
    public function list(
        string $threadID,
        array|EventListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EventListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $sessionID = $parsed['sessionID'];
        unset($parsed['sessionID']);
        $query_params = array_flip(['limit', 'page']);

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/sessions/%1$s/threads/%2$s/events?beta=true', $sessionID, $threadID,
            ],
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
     * @param string $threadID Path param: Path parameter thread_id
     * @param array{
     *   sessionID: string, betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>
     * }|EventStreamParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|ManagedAgentsSessionThreadStatusRescheduledEvent,>,>
     *
     * @throws APIException
     */
    public function streamStream(
        string $threadID,
        array|EventStreamParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = EventStreamParams::parseRequest(
            $params,
            $requestOptions,
        );
        $sessionID = $parsed['sessionID'];
        unset($parsed['sessionID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: [
                'v1/sessions/%1$s/threads/%2$s/stream?beta=true', $sessionID, $threadID,
            ],
            headers: Util::array_transform_keys(
                ['Accept' => 'text/event-stream', ...$parsed],
                ['betas' => 'anthropic-beta'],
            ),
            options: RequestOptions::parse(
                ['extraHeaders' => ['anthropic-beta' => 'managed-agents-2026-04-01']],
                $options,
            ),
            convert: ManagedAgentsStreamSessionThreadEvents::class,
            stream: SSEStream::class,
        );
    }
}
