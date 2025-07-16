<?php

declare(strict_types=1);

namespace Anthropic\Parameters\MessageCountTokensParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class System implements StaticConverter
{
    use Union;
}

System::__introspect();
