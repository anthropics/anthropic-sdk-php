<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class MessageBatchResult implements StaticConverter
{
    use Union;
}

MessageBatchResult::__introspect();
