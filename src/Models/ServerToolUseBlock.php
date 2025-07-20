<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type server_tool_use_block_alias = array{
 *   id: string, input: mixed, name: string, type: string
 * }
 */
final class ServerToolUseBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $name = 'web_search';

    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(string $id, mixed $input)
    {
        self::introspect();

        $this->id = $id;
        $this->input = $input;
    }
}
