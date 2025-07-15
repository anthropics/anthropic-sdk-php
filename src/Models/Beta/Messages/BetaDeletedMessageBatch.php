<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaDeletedMessageBatch implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public string $type = 'message_batch_deleted';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        string $type = 'message_batch_deleted'
    ) {
        $this->id = $id;
        $this->type = $type;
    }
}

BetaDeletedMessageBatch::_loadMetadata();
