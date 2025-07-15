<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaMCPToolUseBlock implements BaseModel
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
    public string $type = 'mcp_tool_use';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        mixed $input,
        string $name,
        string $serverName,
        string $type = 'mcp_tool_use',
    ) {
        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
        $this->serverName = $serverName;
        $this->type = $type;
    }
}

BetaMCPToolUseBlock::_loadMetadata();
