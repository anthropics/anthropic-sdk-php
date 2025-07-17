<?php

declare(strict_types=1);

namespace Anthropic\Core\Contracts;

use JsonSerializable;
use Stringable;

/**
 * @internal
 *
 * @extends \ArrayAccess<string, mixed>
 */
interface BaseModel extends \ArrayAccess, JsonSerializable, Stringable, StaticConverter
{
    /** @return array<string, mixed> */
    public function toArray(): array;
}
