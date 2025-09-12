<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * This is a single line in the response `.jsonl` file and does not represent the response as a whole.
 *
 * @phpstan-type message_batch_individual_response = array{
 *   customID: string,
 *   result: MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult,
 * }
 * When used in a response, this type parameter can be used to define a $rawResponse property.
 * @template TRawResponse of object = object{}
 *
 * @mixin TRawResponse
 */
final class MessageBatchIndividualResponse implements BaseModel
{
    /** @use SdkModel<message_batch_individual_response> */
    use SdkModel;

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    #[Api('custom_id')]
    public string $customID;

    /**
     * Processing result for this request.
     *
     * Contains a Message output if processing was successful, an error response if processing failed, or the reason why processing was not attempted, such as cancellation or expiration.
     */
    #[Api(union: MessageBatchResult::class)]
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
     */
    public static function with(
        string $customID,
        MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult $result,
    ): self {
        $obj = new self;

        $obj->customID = $customID;
        $obj->result = $result;

        return $obj;
    }

    /**
     * Developer-provided ID created for each request in a Message Batch. Useful for matching results to requests, as results may be given out of request order.
     *
     * Must be unique for each request within the Message Batch.
     */
    public function withCustomID(string $customID): self
    {
        $obj = clone $this;
        $obj->customID = $customID;

        return $obj;
    }

    /**
     * Processing result for this request.
     *
     * Contains a Message output if processing was successful, an error response if processing failed, or the reason why processing was not attempted, such as cancellation or expiration.
     */
    public function withResult(
        MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult $result,
    ): self {
        $obj = clone $this;
        $obj->result = $result;

        return $obj;
    }
}
