<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages\BatchCreateParam\Request\Params;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type service_tier_alias = ServiceTier::*
 */
final class ServiceTier implements ConverterSource
{
    use Enum;

    final public const AUTO = 'auto';

    final public const STANDARD_ONLY = 'standard_only';
}
