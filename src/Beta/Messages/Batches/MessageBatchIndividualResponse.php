<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * This is a single line in the response `.jsonl` file and does not represent the response as a whole.
 *
 * @phpstan-type message_batch_individual_response_alias = array{
 *   customID: string,
 *   result: MessageBatchSucceededResult|MessageBatchErroredResult|MessageBatchCanceledResult|MessageBatchExpiredResult,
 * }
 */
final class MessageBatchIndividualResponse implements BaseModel
{
    use Model;

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
    public MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function from(
        string $customID,
        MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result,
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
    public function setCustomID(string $customID): self
    {
        $this->customID = $customID;

        return $this;
    }

    /**
     * Processing result for this request.
     *
     * Contains a Message output if processing was successful, an error response if processing failed, or the reason why processing was not attempted, such as cancellation or expiration.
     */
    public function setResult(
        MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result,
    ): self {
        $this->result = $result;

        return $this;
    }
}
