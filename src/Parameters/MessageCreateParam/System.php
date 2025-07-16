<?php

declare(strict_types=1);

namespace Anthropic\Parameters\MessageCreateParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class System implements StaticConverter
{
    use Union;
}
