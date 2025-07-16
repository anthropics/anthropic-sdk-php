<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaRawMessageStreamEvent implements StaticConverter
{
    use Union;
}

BetaRawMessageStreamEvent::__introspect();
