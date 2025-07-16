<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class MessageBatchCanceledResult implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'canceled';

    final public function __construct() {}
}

MessageBatchCanceledResult::__introspect();
