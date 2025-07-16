<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ServerToolUseBlock\Name;
use Anthropic\Models\ServerToolUseBlock\Type;

final class ServerToolUseBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    /** @var Name::* $name */
    #[Api]
    public string $name;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'server_tool_use';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Name::* $name
     * @param Type::* $type
     */
    final public function __construct(
        string $id,
        mixed $input,
        string $name,
        string $type = 'server_tool_use'
    ) {
        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
        $this->type = $type;
    }
}

ServerToolUseBlock::_loadMetadata();
