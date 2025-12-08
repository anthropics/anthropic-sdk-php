<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type DeletedMessageBatchShape = array{
 *   id: string, type: 'message_batch_deleted'
 * }
 */
final class DeletedMessageBatch implements BaseModel
{
    /** @use SdkModel<DeletedMessageBatchShape> */
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For Message Batches, this is always `"message_batch_deleted"`.
     *
     * @var 'message_batch_deleted' $type
     */
    #[Required]
    public string $type = 'message_batch_deleted';

    /**
     * ID of the Message Batch.
     */
    #[Required]
    public string $id;

    /**
     * `new DeletedMessageBatch()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DeletedMessageBatch::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DeletedMessageBatch)->withID(...)
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
    public static function with(string $id): self
    {
        $obj = new self;

        $obj['id'] = $id;

        return $obj;
    }

    /**
     * ID of the Message Batch.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }
}
