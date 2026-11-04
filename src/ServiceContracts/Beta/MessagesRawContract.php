<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta;

use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Beta\Messages\BetaMessageTokensCount;
use Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;
use Anthropic\Beta\Messages\BetaRawContentBlockStopEvent;
use Anthropic\Beta\Messages\BetaRawMessageDeltaEvent;
use Anthropic\Beta\Messages\BetaRawMessageStartEvent;
use Anthropic\Beta\Messages\BetaRawMessageStopEvent;
use Anthropic\Beta\Messages\MessageCountTokensParams;
use Anthropic\Beta\Messages\MessageCreateParams;
use Anthropic\ClaudeCodeKeyCreatorNotMemberException;
use Anthropic\ClaudeCodeVersionTooOldException;
use Anthropic\CMEKKeyDisabledException;
use Anthropic\CMEKKeyNetworkBlockedException;
use Anthropic\CMEKKeyUnreachableException;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\EnforcedSpendLimitReachedException;
use Anthropic\Messages\AvailableToolsLimitExceededException;
use Anthropic\Messages\CompactionBlockAmbiguousException;
use Anthropic\Messages\CompactionBlockMisplacedException;
use Anthropic\Messages\CompactionContentMismatchException;
use Anthropic\Messages\CompactionIncompleteTurnException;
use Anthropic\Messages\CompactionNothingToSummarizeException;
use Anthropic\Messages\CompactionSignatureInvalidException;
use Anthropic\Messages\CompactionToolChangesMismatchException;
use Anthropic\Messages\CompactionTooManyToolReferencesException;
use Anthropic\Messages\CompactionUnavailableException;
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
use Anthropic\Skills\SkillReadBlockedUndecryptableException;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface MessagesRawContract
{
    /**
     * @api
     *
     * @param array<string,mixed>|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaMessage>
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MessageCreateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BaseStream<BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent>>
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
    ): BaseResponse;

    /**
     * @api
     *
     * @param array<string,mixed>|MessageCountTokensParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<BetaMessageTokensCount>
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
    ): BaseResponse;
}
