<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type deleted_message_batch_alias = array{id: string, type: string}
 */
final class DeletedMessageBatch implements BaseModel
{
    use Model;

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
    public static function from(string $id): self
    {
        $obj = new self;

        $obj->id = $id;

        return $obj;
    }

    /**
     * ID of the Message Batch.
     */
    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
