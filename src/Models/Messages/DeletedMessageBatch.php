<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class DeletedMessageBatch implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'message_batch_deleted';

    #[Api]
    public string $id;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $id)
    {
        $this->id = $id;

        self::_introspect();
    }
}
