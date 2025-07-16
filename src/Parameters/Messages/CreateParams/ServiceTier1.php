<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\CreateParams;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class ServiceTier implements StaticConverter
{
    use Enum;

    final public const AUTO = 'auto';

    final public const STANDARD_ONLY = 'standard_only';
}

ServiceTier::__introspect();
