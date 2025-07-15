<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaMessage;

final class BetaMessageBatchSucceededResult implements BaseModel
{
    use Model;

    #[Api]
    public BetaMessage $message;

    #[Api]
    public string $type = 'succeeded';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaMessage $message,
        string $type = 'succeeded'
    ) {
        $this->message = $message;
        $this->type = $type;
    }
}

BetaMessageBatchSucceededResult::_loadMetadata();
