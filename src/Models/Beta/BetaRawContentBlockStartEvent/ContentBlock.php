<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRawContentBlockStartEvent;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class ContentBlock implements StaticConverter
{
    use Union;
}

ContentBlock::__introspect();
