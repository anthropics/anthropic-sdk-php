<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ThinkingConfigDisabled implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'disabled';

    final public function __construct()
    {
        self::_introspect();
    }
}
