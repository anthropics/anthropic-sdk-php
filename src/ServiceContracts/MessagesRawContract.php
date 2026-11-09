<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts;

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
use Anthropic\Messages\ThreadAlreadyContinuedException;
use Anthropic\Messages\ThreadContinueInFlightException;
use Anthropic\Messages\ThreadFingerprintMismatchException;
use Anthropic\Messages\ThreadNotFoundException;
use Anthropic\Messages\ThreadUnsupportedRequestException;
use Anthropic\Messages\ToolNameConflictException;
use Anthropic\Messages\ToolReferenceUnresolvedException;
use Anthropic\OrganizationOnHoldException;
use Anthropic\RampLimitExceededException;
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
     * @return BaseResponse<Message>
     *
     * @throws AvailableToolsLimitExceededException
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws ClaudeCodeVersionTooOldException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws CompactionBlockAmbiguousException
     * @throws CompactionBlockMisplacedException
     * @throws CompactionContentMismatchException
     * @throws CompactionIncompleteTurnException
     * @throws CompactionNothingToSummarizeException
     * @throws CompactionSignatureInvalidException
     * @throws CompactionTooManyToolReferencesException
     * @throws CompactionToolChangesMismatchException
     * @throws OrganizationOnHoldException
     * @throws RequestBodyEncodingInvalidException
     * @throws RequestBodyEncodingUnsupportedException
     * @throws ThreadAlreadyContinuedException
     * @throws ThreadContinueInFlightException
     * @throws ThreadFingerprintMismatchException
     * @throws ThreadUnsupportedRequestException
     * @throws ToolNameConflictException
     * @throws ToolReferenceUnresolvedException
     * @throws ThreadNotFoundException
     * @throws SkillReadBlockedUndecryptableException
     * @throws RequestBodyTooLargeAfterDecodingException
     * @throws EnforcedSpendLimitReachedException
     * @throws RampLimitExceededException
     * @throws CMEKKeyUnreachableException
     * @throws CompactionUnavailableException
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
     * @return BaseResponse<BaseStream<RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent>>
     *
     * @throws AvailableToolsLimitExceededException
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws ClaudeCodeVersionTooOldException
     * @throws CMEKKeyDisabledException
     * @throws CMEKKeyNetworkBlockedException
     * @throws CompactionBlockAmbiguousException
     * @throws CompactionBlockMisplacedException
     * @throws CompactionContentMismatchException
     * @throws CompactionIncompleteTurnException
     * @throws CompactionNothingToSummarizeException
     * @throws CompactionSignatureInvalidException
     * @throws CompactionTooManyToolReferencesException
     * @throws CompactionToolChangesMismatchException
     * @throws OrganizationOnHoldException
     * @throws RequestBodyEncodingInvalidException
     * @throws RequestBodyEncodingUnsupportedException
     * @throws ThreadAlreadyContinuedException
     * @throws ThreadContinueInFlightException
     * @throws ThreadFingerprintMismatchException
     * @throws ThreadUnsupportedRequestException
     * @throws ToolNameConflictException
     * @throws ToolReferenceUnresolvedException
     * @throws ThreadNotFoundException
     * @throws SkillReadBlockedUndecryptableException
     * @throws RequestBodyTooLargeAfterDecodingException
     * @throws EnforcedSpendLimitReachedException
     * @throws RampLimitExceededException
     * @throws CMEKKeyUnreachableException
     * @throws CompactionUnavailableException
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
     * @return BaseResponse<MessageTokensCount>
     *
     * @throws AvailableToolsLimitExceededException
     * @throws ClaudeCodeKeyCreatorNotMemberException
     * @throws CompactionBlockAmbiguousException
     * @throws CompactionBlockMisplacedException
     * @throws CompactionContentMismatchException
     * @throws CompactionNothingToSummarizeException
     * @throws CompactionSignatureInvalidException
     * @throws CompactionToolChangesMismatchException
     * @throws OrganizationOnHoldException
     * @throws RequestBodyEncodingInvalidException
     * @throws RequestBodyEncodingUnsupportedException
     * @throws ToolNameConflictException
     * @throws ToolReferenceUnresolvedException
     * @throws RequestBodyTooLargeAfterDecodingException
     * @throws EnforcedSpendLimitReachedException
     * @throws CompactionUnavailableException
     * @throws APIException
     */
    public function countTokens(
        array|MessageCountTokensParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse;
}
