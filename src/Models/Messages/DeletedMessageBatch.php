<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $id)
    {
        self::introspect();

        $this->id = $id;
    }
}
