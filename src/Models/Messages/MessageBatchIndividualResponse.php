<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $customID,
        MessageBatchCanceledResult|MessageBatchErroredResult|MessageBatchExpiredResult|MessageBatchSucceededResult $result,
    ) {
        self::introspect();

        $this->customID = $customID;
        $this->result = $result;
    }
}
