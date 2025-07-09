<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaServerToolUseBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    #[Api]
    public string $name;

    #[Api]
    public string $type;

    /**
     * @param string $id
     * @param mixed  $input
     * @param string $name
     * @param string $type
     */
    final public function __construct($id, $input, $name, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaServerToolUseBlock::_loadMetadata();
