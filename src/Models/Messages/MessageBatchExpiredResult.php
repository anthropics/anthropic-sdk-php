<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class MessageBatchExpiredResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'expired';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $type = 'expired')
    {
        $this->type = $type;
    }
}

MessageBatchExpiredResult::_loadMetadata();
