<?php

declare(strict_types=1);

namespace Anthropic\Services;

use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\ClaudeCodeVersionTooOldException;
use Anthropic\Client;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\CMEKKeyUnreachableException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Implementation\RawResponse;
use Anthropic\Core\Util;
use Anthropic\EnforcedSpendLimitReachedException;
use Anthropic\Lib\Tracing\Tracing;
use Anthropic\Messages\AvailableToolsLimitExceededException;
use Anthropic\Messages\CacheControlEphemeral;
use Anthropic\Messages\CompactionBlockAmbiguousException;
use Anthropic\Messages\CompactionBlockMisplacedException;
use Anthropic\Messages\CompactionContentMismatchException;
use Anthropic\Messages\CompactionIncompleteTurnException;
use Anthropic\Messages\CompactionNothingToSummarizeException;
use Anthropic\Messages\CompactionSignatureInvalidException;
use Anthropic\Messages\CompactionToolChangesMismatchException;
use Anthropic\Messages\CompactionTooManyToolReferencesException;
use Anthropic\Messages\CompactionUnavailableException;
use Anthropic\Messages\DiagnosticsParam;
use Anthropic\Messages\Message;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
use Anthropic\Messages\MessageCreateParams\ServiceTier;
use Anthropic\Messages\MessageCreateParams\Speed;
use Anthropic\Messages\MessageTokensCount;
use Anthropic\Messages\Metadata;
use Anthropic\Messages\Model;
use Anthropic\Messages\OutputConfig;
use Anthropic\Messages\RawContentBlockDeltaEvent;
use Anthropic\Messages\RawContentBlockStartEvent;
use Anthropic\Messages\RawContentBlockStopEvent;
use Anthropic\Messages\RawMessageDeltaEvent;
use Anthropic\Messages\RawMessageStartEvent;
use Anthropic\Messages\RawMessageStopEvent;
use Anthropic\Messages\RawMessageStreamEvent;
use Anthropic\Messages\ThreadAlreadyContinuedException;
use Anthropic\Messages\ThreadContinueInFlightException;
use Anthropic\Messages\ThreadFingerprintMismatchException;
use Anthropic\Messages\ThreadNotFoundException;
use Anthropic\Messages\ThreadUnsupportedRequestException;
use Anthropic\Messages\ToolNameConflictException;
use Anthropic\Messages\ToolReferenceUnresolvedException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\RequestBodyEncodingInvalidException;
use Anthropic\RequestBodyEncodingUnsupportedException;
use Anthropic\RequestBodyTooLargeAfterDecodingException;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\MessagesRawContract;
use Anthropic\Skills\SkillReadBlockedUndecryptableException;
use Anthropic\SSEStream;

/**
 * @phpstan-import-type MessageParamShape from \Anthropic\Messages\MessageParam
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type MessageCreateParamsContainerShape from \Anthropic\Messages\MessageCreateParamsContainer
 * @phpstan-import-type DiagnosticsParamShape from \Anthropic\Messages\DiagnosticsParam
 * @phpstan-import-type MetadataShape from \Anthropic\Messages\Metadata
 * @phpstan-import-type OutputConfigShape from \Anthropic\Messages\OutputConfig
 * @phpstan-import-type SystemShape from \Anthropic\Messages\MessageCreateParams\System
 * @phpstan-import-type ThinkingConfigParamShape from \Anthropic\Messages\ThinkingConfigParam
 * @phpstan-import-type ToolChoiceShape from \Anthropic\Messages\ToolChoice
 * @phpstan-import-type ToolUnionShape from \Anthropic\Messages\ToolUnion
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 * @phpstan-import-type SystemShape from \Anthropic\Messages\MessageCountTokensParams\System as SystemShape1
 * @phpstan-import-type MessageCountTokensToolShape from \Anthropic\Messages\MessageCountTokensTool
 */
final class MessagesRawService implements MessagesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Send a structured list of input messages with text and/or image content, and the model will generate the next message in the conversation.
     *
     * The Messages API can be used for either single queries or stateless multi-turn conversations.
     *
     * Learn more about the Messages API in our [user guide](https://platform.claude.com/docs/en/get-started)
     *
     * @param array{
     *   maxTokens: int,
     *   messages: list<MessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   cacheControl?: CacheControlEphemeral|CacheControlEphemeralShape|null,
     *   container?: MessageCreateParamsContainerShape|null,
     *   diagnostics?: DiagnosticsParam|DiagnosticsParamShape|null,
     *   inferenceGeo?: string|null,
     *   metadata?: Metadata|MetadataShape,
     *   outputConfig?: OutputConfig|OutputConfigShape,
     *   serviceTier?: ServiceTier|value-of<ServiceTier>,
     *   speed?: Speed|value-of<Speed>|null,
     *   stopSequences?: list<string>,
     *   system?: SystemShape,
     *   thinking?: ThinkingConfigParamShape,
     *   toolChoice?: ToolChoiceShape,
     *   tools?: list<ToolUnionShape>,
     *   userProfileID?: string,
     *   workspaceID?: string,
     * }|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<Message>
     *
     * @throws AvailableToolsLimitExceededException The tools available after a message exceed a limit on their number or their size.
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws ClaudeCodeVersionTooOldException The request comes from a Claude Code version older than the minimum that the requested model or the organization requires. Update Claude Code, then retry.
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws CMEKKeyNetworkBlockedException The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
     * @throws CompactionBlockAmbiguousException `messages` holds more than one `compaction` block with content. Send only the block the conversation returned last.
     * @throws CompactionBlockMisplacedException The `compaction` block is not the first block of the conversation, or is in a `system` message.
     * @throws CompactionContentMismatchException The `compaction` block's `content` differs from the text its `signature` recorded.
     * @throws CompactionIncompleteTurnException The compaction request ends on an `assistant` turn that is not finished.
     * @throws CompactionNothingToSummarizeException `messages` holds no `user` or `assistant` content to summarize or adopt.
     * @throws CompactionSignatureInvalidException The `compaction` block's `signature` does not verify.
     * @throws CompactionTooManyToolReferencesException The conversation references more distinct tools than a `compaction` block can record.
     * @throws CompactionToolChangesMismatchException The `compaction` block's `tool_changes` differs from what was returned with the block.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws RequestBodyEncodingInvalidException The request body is not valid for its `Content-Encoding`.
     * @throws RequestBodyEncodingUnsupportedException The request's `Content-Encoding` is not supported.
     * @throws ThreadAlreadyContinuedException The response that `previous_message_id` names has already been continued, and each response can be continued only once. Continue from the Thread's most recent response `id`.
     * @throws ThreadContinueInFlightException Another request is still continuing from the same `previous_message_id`. Wait for it to complete and continue from its response `id`, or replay the full conversation with `thread: {"type": "create"}`.
     * @throws ThreadFingerprintMismatchException A field that must stay the same across a Thread's turns differs from the value stored with the Thread; the message names each such field. Send the stored values, or replay the full conversation with `thread: {"type": "create"}` to change them.
     * @throws ThreadUnsupportedRequestException The request combines `thread` with a request field or an organization setting that Threads do not support; `unsupported`, when present, names it. Send the full conversation without `thread`, or change that field.
     * @throws ToolNameConflictException A tool made available in `messages` takes a name that an available tool of another kind, or of another MCP server, already holds.
     * @throws ToolReferenceUnresolvedException A tool change or MCP tool listing references a tool or MCP server that is not defined at that position in the conversation.
     * @throws ThreadNotFoundException No usable Thread state was found for `previous_message_id`. Replay the full conversation with `thread: {"type": "create"}` to start a new Thread.
     * @throws SkillReadBlockedUndecryptableException A custom skill the request names is stored under an encryption key state the workspace cannot currently decrypt.
     * @throws RequestBodyTooLargeAfterDecodingException The compressed request body exceeds the request size limit once decoded.
     * @throws EnforcedSpendLimitReachedException The organization has crossed the monthly API usage threshold of its API tier.
     * @throws CMEKKeyUnreachableException The workspace's customer-managed encryption key could not be reached. Retry the request; if this continues, check that the key is available in your key management service, or contact Anthropic support.
     * @throws CompactionUnavailableException The compaction could not be completed for a transient server reason. Retry the request.
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
        $header_params = [
            'userProfileID' => 'anthropic-user-profile-id',
            'workspaceID' => 'anthropic-workspace-id',
        ];

        $callSpan = Tracing::startCallSpan($this->client, 'anthropic.messages.create', '/v1/messages', $parsed, $options, $header_params);
        Tracing::recordMessagesCreateRequest($this->client, $callSpan, $parsed);

        $response = $this->client->request(
            method: 'post',
            path: 'v1/messages',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
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
     * @param array{
     *   maxTokens: int,
     *   messages: list<MessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   cacheControl?: CacheControlEphemeral|CacheControlEphemeralShape|null,
     *   container?: MessageCreateParamsContainerShape|null,
     *   diagnostics?: DiagnosticsParam|DiagnosticsParamShape|null,
     *   inferenceGeo?: string|null,
     *   metadata?: Metadata|MetadataShape,
     *   outputConfig?: OutputConfig|OutputConfigShape,
     *   serviceTier?: ServiceTier|value-of<ServiceTier>,
     *   speed?: Speed|value-of<Speed>|null,
     *   stopSequences?: list<string>,
     *   system?: SystemShape,
     *   thinking?: ThinkingConfigParamShape,
     *   toolChoice?: ToolChoiceShape,
     *   tools?: list<ToolUnionShape>,
     *   userProfileID?: string,
     *   workspaceID?: string,
     * }|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent>>
     *
     * @throws AvailableToolsLimitExceededException The tools available after a message exceed a limit on their number or their size.
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws ClaudeCodeVersionTooOldException The request comes from a Claude Code version older than the minimum that the requested model or the organization requires. Update Claude Code, then retry.
     * @throws CMEKKeyDisabledException The workspace's customer-managed encryption key is disabled or revoked. Re-enable the key, then retry.
     * @throws CMEKKeyNetworkBlockedException The key management service's network access controls blocked the request to the workspace's customer-managed encryption key. The key itself may be healthy.
     * @throws CompactionBlockAmbiguousException `messages` holds more than one `compaction` block with content. Send only the block the conversation returned last.
     * @throws CompactionBlockMisplacedException The `compaction` block is not the first block of the conversation, or is in a `system` message.
     * @throws CompactionContentMismatchException The `compaction` block's `content` differs from the text its `signature` recorded.
     * @throws CompactionIncompleteTurnException The compaction request ends on an `assistant` turn that is not finished.
     * @throws CompactionNothingToSummarizeException `messages` holds no `user` or `assistant` content to summarize or adopt.
     * @throws CompactionSignatureInvalidException The `compaction` block's `signature` does not verify.
     * @throws CompactionTooManyToolReferencesException The conversation references more distinct tools than a `compaction` block can record.
     * @throws CompactionToolChangesMismatchException The `compaction` block's `tool_changes` differs from what was returned with the block.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws RequestBodyEncodingInvalidException The request body is not valid for its `Content-Encoding`.
     * @throws RequestBodyEncodingUnsupportedException The request's `Content-Encoding` is not supported.
     * @throws ThreadAlreadyContinuedException The response that `previous_message_id` names has already been continued, and each response can be continued only once. Continue from the Thread's most recent response `id`.
     * @throws ThreadContinueInFlightException Another request is still continuing from the same `previous_message_id`. Wait for it to complete and continue from its response `id`, or replay the full conversation with `thread: {"type": "create"}`.
     * @throws ThreadFingerprintMismatchException A field that must stay the same across a Thread's turns differs from the value stored with the Thread; the message names each such field. Send the stored values, or replay the full conversation with `thread: {"type": "create"}` to change them.
     * @throws ThreadUnsupportedRequestException The request combines `thread` with a request field or an organization setting that Threads do not support; `unsupported`, when present, names it. Send the full conversation without `thread`, or change that field.
     * @throws ToolNameConflictException A tool made available in `messages` takes a name that an available tool of another kind, or of another MCP server, already holds.
     * @throws ToolReferenceUnresolvedException A tool change or MCP tool listing references a tool or MCP server that is not defined at that position in the conversation.
     * @throws ThreadNotFoundException No usable Thread state was found for `previous_message_id`. Replay the full conversation with `thread: {"type": "create"}` to start a new Thread.
     * @throws SkillReadBlockedUndecryptableException A custom skill the request names is stored under an encryption key state the workspace cannot currently decrypt.
     * @throws RequestBodyTooLargeAfterDecodingException The compressed request body exceeds the request size limit once decoded.
     * @throws EnforcedSpendLimitReachedException The organization has crossed the monthly API usage threshold of its API tier.
     * @throws CMEKKeyUnreachableException The workspace's customer-managed encryption key could not be reached. Retry the request; if this continues, check that the key is available in your key management service, or contact Anthropic support.
     * @throws CompactionUnavailableException The compaction could not be completed for a transient server reason. Retry the request.
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
        $header_params = [
            'userProfileID' => 'anthropic-user-profile-id',
            'workspaceID' => 'anthropic-workspace-id',
        ];

        $callSpan = Tracing::startCallSpan($this->client, 'anthropic.messages.create', '/v1/messages', $parsed, $options, $header_params);
        Tracing::recordMessagesCreateRequest($this->client, $callSpan, $parsed);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: 'v1/messages',
            headers: Util::array_transform_keys(
                [
                    'Accept' => 'text/event-stream',
                    ...array_intersect_key(
                        $parsed,
                        array_flip(array_keys($header_params))
                    ),
                ],
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
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
     * Count the number of tokens in a Message.
     *
     * The Token Count API can be used to count the number of tokens in a Message, including tools, images, and documents, without creating it.
     *
     * Learn more about token counting in our [user guide](https://platform.claude.com/docs/en/build-with-claude/token-counting)
     *
     * @param array{
     *   messages: list<MessageParamShape>,
     *   model: string|Model|value-of<Model>,
     *   cacheControl?: CacheControlEphemeral|CacheControlEphemeralShape|null,
     *   outputConfig?: OutputConfig|OutputConfigShape,
     *   speed?: MessageCountTokensParams\Speed|value-of<MessageCountTokensParams\Speed>|null,
     *   system?: SystemShape1,
     *   thinking?: ThinkingConfigParamShape,
     *   toolChoice?: ToolChoiceShape,
     *   tools?: list<MessageCountTokensToolShape>,
     *   userProfileID?: string,
     *   workspaceID?: string,
     * }|MessageCountTokensParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<MessageTokensCount>
     *
     * @throws AvailableToolsLimitExceededException The tools available after a message exceed a limit on their number or their size.
     * @throws ClaudeCodeKeyCreatorNotMemberException The API key belongs to the Claude Code workspace, and the user who created it is no longer a member of the organization or of that workspace.
     * @throws CompactionBlockAmbiguousException `messages` holds more than one `compaction` block with content. Send only the block the conversation returned last.
     * @throws CompactionBlockMisplacedException The `compaction` block is not the first block of the conversation, or is in a `system` message.
     * @throws CompactionContentMismatchException The `compaction` block's `content` differs from the text its `signature` recorded.
     * @throws CompactionNothingToSummarizeException `messages` holds no `user` or `assistant` content to summarize or adopt.
     * @throws CompactionSignatureInvalidException The `compaction` block's `signature` does not verify.
     * @throws CompactionToolChangesMismatchException The `compaction` block's `tool_changes` differs from what was returned with the block.
     * @throws OrganizationOnHoldException Anthropic has disabled the organization for trust and safety reasons. An organization disabled for any other reason, such as billing, does not get this code. `appeal_url`, when present, is where the organization can appeal.
     * @throws RequestBodyEncodingInvalidException The request body is not valid for its `Content-Encoding`.
     * @throws RequestBodyEncodingUnsupportedException The request's `Content-Encoding` is not supported.
     * @throws ToolNameConflictException A tool made available in `messages` takes a name that an available tool of another kind, or of another MCP server, already holds.
     * @throws ToolReferenceUnresolvedException A tool change or MCP tool listing references a tool or MCP server that is not defined at that position in the conversation.
     * @throws RequestBodyTooLargeAfterDecodingException The compressed request body exceeds the request size limit once decoded.
     * @throws EnforcedSpendLimitReachedException The organization has crossed the monthly API usage threshold of its API tier.
     * @throws CompactionUnavailableException The compaction could not be completed for a transient server reason. Retry the request.
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
        $header_params = [
            'userProfileID' => 'anthropic-user-profile-id',
            'workspaceID' => 'anthropic-workspace-id',
        ];

        $callSpan = Tracing::startCallSpan($this->client, 'anthropic.messages.count_tokens', '/v1/messages/count_tokens', $parsed, $options, $header_params);

        $response = $this->client->request(
            method: 'post',
            path: 'v1/messages/count_tokens',
            headers: Util::array_transform_keys(
                array_intersect_key($parsed, array_flip(array_keys($header_params))),
                $header_params,
            ),
            body: (object) array_diff_key(
                $parsed,
                array_flip(array_keys($header_params))
            ),
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
