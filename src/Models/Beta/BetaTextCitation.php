<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaTextCitation implements StaticConverter
{
    use Union;
}

BetaTextCitation::__introspect();
