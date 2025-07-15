<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaMessageBatchCanceledResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'canceled';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $type = 'canceled')
    {
        $this->type = $type;
    }
}

BetaMessageBatchCanceledResult::_loadMetadata();
