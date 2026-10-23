<?php

declare(strict_types=1);

namespace Anthropic\Foundry\Services;

use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Implementation\RawResponse;
use Anthropic\Core\Util;
use Anthropic\Foundry\Client;
use Anthropic\Lib\Tracing\Tracing;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawContentBlockStopEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;
use Anthropic\Messages\RawMessageStreamEvent;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\MessagesRawContract;
use Anthropic\SSEStream;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class MessagesRawService implements MessagesRawContract
{
    private const HEADER_PARAMS = [
        'userProfileID' => 'anthropic-user-profile-id',
        'workspaceID' => 'anthropic-workspace-id',
    ];

    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * @param array<string,mixed>|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Message>
     *
     * @throws APIException
     */
    public function create(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );

        $callSpan = Tracing::startCallSpan($this->client, 'anthropic.messages.create', '/v1/messages', $parsed, $options, self::HEADER_PARAMS);
        Tracing::recordMessagesCreateRequest($this->client, $callSpan, $parsed);

        $response = $this->client->request(
            method: 'post',
            path: 'v1/messages',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, self::HEADER_PARAMS),
                self::HEADER_PARAMS,
            ),
            body: (object) array_diff_key($parsed, self::HEADER_PARAMS),
            options: $options->withApiCall(new ApiCallInfo(
                name: $callSpan?->name,
                span: $callSpan?->span,
            )),
            convert: Message::class,
        );

        // Only the response that the SDK's own `request()` returns records on the span: any other is returned as it is.
        // @phpstan-ignore-next-line return.type
        return $response instanceof RawResponse ? $response->thenUnwrap(fn (mixed $message, mixed $decoded): mixed => Tracing::recordMessagesCreateResponse($this->client, $callSpan, $parsed, $message, $decoded)) : $response;
    }

    /**
     * @api
     *
     * @param array<string,mixed>|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent,>,>
     *
     * @throws APIException
     */
    public function createStream(
        array|MessageCreateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCreateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $parsed['stream'] = true;

        $callSpan = Tracing::startCallSpan($this->client, 'anthropic.messages.create', '/v1/messages', $parsed, $options, self::HEADER_PARAMS);
        Tracing::recordMessagesCreateRequest($this->client, $callSpan, $parsed);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages',
            headers: Util::array_transform_keys(
                [
                    'Accept' => 'text/event-stream',
                    ...array_intersect_key($parsed, self::HEADER_PARAMS),
                ],
                self::HEADER_PARAMS,
            ),
            body: (object) array_diff_key($parsed, self::HEADER_PARAMS),
            options: $options->withApiCall(new ApiCallInfo(
                name: $callSpan?->name,
                span: $callSpan?->span,
            )),
            convert: RawMessageStreamEvent::class,
            stream: SSEStream::class,
        );
    }

    /**
     * @api
     *
     * @param array<string,mixed>|MessageCountTokensParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageTokensCount>
     *
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = MessageCountTokensParams::parseRequest(
            $params,
            $requestOptions,
        );

        $callSpan = Tracing::startCallSpan($this->client, 'anthropic.messages.count_tokens', '/v1/messages/count_tokens', $parsed, $options, self::HEADER_PARAMS);

        $response = $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, self::HEADER_PARAMS),
                self::HEADER_PARAMS,
            ),
            body: (object) array_diff_key($parsed, self::HEADER_PARAMS),
            options: $options->withApiCall(new ApiCallInfo(
                name: $callSpan?->name,
                span: $callSpan?->span,
            )),
            convert: MessageTokensCount::class,
        );

        // Only the response that the SDK's own `request()` returns records on the span: any other is returned as it is.
        // @phpstan-ignore-next-line return.type
        return $response instanceof RawResponse ? $response->thenUnwrap(static fn (mixed $count): mixed => Tracing::recordMessagesCountTokensResponse($callSpan, $count)) : $response;
    }
}
