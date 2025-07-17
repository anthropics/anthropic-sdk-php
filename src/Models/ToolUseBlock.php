<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ToolUseBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    #[Api]
    public string $name;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $id, mixed $input, string $name)
    {
        self::introspect();

        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
    }
}
