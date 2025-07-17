<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

/**
 * @internal
 */
interface Introspectable
{
    /**
     * @internal
     */
    public static function introspect(): void;
}
