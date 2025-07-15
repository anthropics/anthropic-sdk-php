<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ErrorResponse;

final class MessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public ErrorResponse $error;

    #[Api]
    public string $type = 'errored';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        ErrorResponse $error,
        string $type = 'errored'
    ) {
        $this->error = $error;
        $this->type = $type;
    }
}

MessageBatchErroredResult::_loadMetadata();
