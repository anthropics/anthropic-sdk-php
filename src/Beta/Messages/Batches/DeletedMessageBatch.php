<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type deleted_message_batch_alias = array{id: string, type: string}
 */
final class DeletedMessageBatch implements BaseModel
{
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For Message Batches, this is always `"message_batch_deleted"`.
     */
    #[Api]
    public string $type = 'message_batch_deleted';

    /**
     * ID of the Message Batch.
     */
    #[Api]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $id): self
    {
        $obj = new self;

        $obj->id = $id;

        return $obj;
    }

    /**
     * ID of the Message Batch.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj->id = $id;

        return $obj;
    }
}
