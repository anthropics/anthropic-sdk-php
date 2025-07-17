<?php

declare(strict_types=1);

namespace Anthropic\Core\Concerns;

use Anthropic\Core\Serde\CoerceState;
use Anthropic\Core\Serde\DumpState;

trait Union
{
    public static function _introspect(): void {}

    // @phpstan-ignore-next-line
    public static function discriminator(): ?string
    {
        return null;
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return [];
    }

    public static function coerce(mixed $value, CoerceState $state): mixed
    {
        return $value;
    }

    public static function dump(mixed $value, DumpState $state): mixed
    {
        return $value;
    }
}
