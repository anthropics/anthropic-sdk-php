<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ToolChoiceNone implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'none';

    final public function __construct()
    {
        self::introspect();
    }
}
