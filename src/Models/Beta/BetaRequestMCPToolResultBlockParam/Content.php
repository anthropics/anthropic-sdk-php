<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRequestMCPToolResultBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class Content implements StaticConverter
{
    use Union;
}

Content::__introspect();
