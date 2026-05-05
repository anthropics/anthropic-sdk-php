<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Sessions;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Events\EventListParams\Order;
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
use Anthropic\Beta\Sessions\Events\ManagedAgentsSendSessionEvents;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionDeletedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;
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
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Sessions\EventsContract;

/**
 * @phpstan-import-type ManagedAgentsEventParamsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsEventParams
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class EventsService implements EventsContract
{
    /**
     * @api
     */
    public EventsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new EventsRawService($client);
    }

    /**
     * @api
     *
     * List Events
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param \DateTimeInterface $createdAtGt query param: Return events created after this time (exclusive)
     * @param \DateTimeInterface $createdAtGte query param: Return events created at or after this time (inclusive)
     * @param \DateTimeInterface $createdAtLt query param: Return events created before this time (exclusive)
     * @param \DateTimeInterface $createdAtLte query param: Return events created at or before this time (inclusive)
     * @param int $limit Query param: Query parameter for limit
     * @param Order|value-of<Order> $order Query param: Sort direction for results, ordered by created_at. Defaults to asc (chronological).
     * @param string $page query param: Opaque pagination cursor from a previous response's next_page
     * @param list<string> $types Query param: Filter by event type. Values match the `type` field on returned events (for example, `user.message` or `agent.tool_use`). Omit to return all event types.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|ManagedAgentsSessionThreadStatusRescheduledEvent,>
     *
     * @throws APIException
     */
    public function list(
        string $sessionID,
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $page = null,
        ?array $types = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'createdAtGt' => $createdAtGt,
                'createdAtGte' => $createdAtGte,
                'createdAtLt' => $createdAtLt,
                'createdAtLte' => $createdAtLte,
                'limit' => $limit,
                'order' => $order,
                'page' => $page,
                'types' => $types,
                'betas' => $betas,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($sessionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * Send Events
     *
     * @param string $sessionID Path param: Path parameter session_id
     * @param list<ManagedAgentsEventParamsShape> $events body param: Events to send to the `session`
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function send(
        string $sessionID,
        array $events,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ManagedAgentsSendSessionEvents {
        $params = Util::removeNulls(['events' => $events, 'betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->send($sessionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }

    /**
     * @api
     *
     * @param string $sessionID Path parameter session_id
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseStream<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|ManagedAgentsSessionThreadStatusRescheduledEvent,>
     *
     * @throws APIException
     */
    public function streamStream(
        string $sessionID,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BaseStream {
        $params = Util::removeNulls(['betas' => $betas]);

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->streamStream($sessionID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
