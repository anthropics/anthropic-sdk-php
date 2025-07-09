<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaMCPToolUseBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    #[Api]
    public string $name;

    #[Api('server_name')]
    public string $serverName;

    #[Api]
    public string $type;

    /**
     * @param string $id
     * @param mixed  $input
     * @param string $name
     * @param string $serverName
     * @param string $type
     */
    final public function __construct($id, $input, $name, $serverName, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMCPToolUseBlock::_loadMetadata();
