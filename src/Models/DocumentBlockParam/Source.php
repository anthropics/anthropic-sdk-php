<?php

declare(strict_types=1);

namespace Anthropic\Models\DocumentBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class Source implements StaticConverter
{
    use Union;
}

Source::__introspect();
