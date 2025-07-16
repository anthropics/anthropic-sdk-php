<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\BetaErrorResponse;

final class BetaMessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'errored';

    #[Api]
    public BetaErrorResponse $error;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(BetaErrorResponse $error)
    {
        $this->error = $error;
    }
}

BetaMessageBatchErroredResult::_loadMetadata();
