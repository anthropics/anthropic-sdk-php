<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaCitationsDelta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class Citation implements StaticConverter
{
    use Union;
}
