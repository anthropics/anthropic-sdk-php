<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaMCPToolUseBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'mcp_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    #[Api]
    public string $name;

    #[Api('server_name')]
    public string $serverName;

    #[Api('cache_control', optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $id,
        mixed $input,
        string $name,
        string $serverName,
        ?BetaCacheControlEphemeral $cacheControl = null,
    ) {
        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
        $this->serverName = $serverName;

        self::_introspect();
        $this->unsetOptionalProperties();

        null !== $cacheControl && $this->cacheControl = $cacheControl;
    }
}
