<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaMessageBatchResult implements StaticConverter
{
    use Union;
}

BetaMessageBatchResult::__introspect();
