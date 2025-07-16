<?php

declare(strict_types=1);

namespace Anthropic\Models\Usage;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class ServiceTier implements StaticConverter
{
    use Enum;

    final public const STANDARD = 'standard';

    final public const PRIORITY = 'priority';

    final public const BATCH = 'batch';
}
