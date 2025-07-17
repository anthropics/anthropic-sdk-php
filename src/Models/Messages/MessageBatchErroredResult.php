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
    public string $type = 'errored';

    #[Api]
    public ErrorResponse $error;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(ErrorResponse $error)
    {
        self::introspect();

        $this->error = $error;
    }
}
