<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\BetaErrorResponse;
use Anthropic\Beta\Messages\BetaMessage;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * This is a single line in the response `.jsonl` file and does not represent the response as a whole.
 *
 * @phpstan-type MessageBatchIndividualResponseShape = array{
 *   customID: string,
 *   result: MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult,
 * }
 */
final class MessageBatchIndividualResponse implements BaseModel
{
    /** @use SdkModel<MessageBatchIndividualResponseShape> */
    use SdkModel;

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    #[Required('custom_id')]
    public string $customID;

    /**
     * Processing result for this request.
     *
     * Contains a Message output if processing was successful, an error response if processing failed, or the reason why processing was not attempted, such as cancellation or expiration.
     */
    #[Required(union: MessageBatchResult::class)]
    public MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult $result;

    /**
     * `new MessageBatchIndividualResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageBatchIndividualResponse::with(customID: ..., result: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageBatchIndividualResponse)->withCustomID(...)->withResult(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param MessageBatchSucceededResult|array{
     *   message: BetaMessage, type?: 'succeeded'
     * }|MessageBatchErroredResult|array{
     *   error: BetaErrorResponse, type?: 'errored'
     * }|MessageBatchCanceledResult|array{
     *   type?: 'canceled'
     * }|MessageBatchExpiredResult|array{type?: 'expired'} $result
     */
    public static function with(
        string $customID,
        MessageBatchSucceededResult|array|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult $result,
    ): self {
        $self = new self;

        $self['customID'] = $customID;
        $self['result'] = $result;

        return $self;
    }

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    public function withCustomID(string $customID): self
    {
        $self = clone $this;
        $self['customID'] = $customID;

        return $self;
    }

    /**
     * Processing result for this request.
     *
     * Contains a Message output if processing was successful, an error response if processing failed, or the reason why processing was not attempted, such as cancellation or expiration.
     *
     * @param MessageBatchSucceededResult|array{
     *   message: BetaMessage, type?: 'succeeded'
     * }|MessageBatchErroredResult|array{
     *   error: BetaErrorResponse, type?: 'errored'
     * }|MessageBatchCanceledResult|array{
     *   type?: 'canceled'
     * }|MessageBatchExpiredResult|array{type?: 'expired'} $result
     */
    public function withResult(
        MessageBatchSucceededResult|array|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult $result,
    ): self {
        $self = clone $this;
        $self['result'] = $result;

        return $self;
    }
}
