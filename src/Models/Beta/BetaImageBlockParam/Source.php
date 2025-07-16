<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaImageBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class Source implements StaticConverter
{
    use Union;
}
