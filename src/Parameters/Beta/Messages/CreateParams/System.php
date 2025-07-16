<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages\CreateParams;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class System implements StaticConverter
{
    use Union;
}

System::__introspect();
