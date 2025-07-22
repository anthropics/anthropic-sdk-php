<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaServerToolUseBlock\Name;

/**
 * @phpstan-type beta_server_tool_use_block_alias = array{
 *   id: string, input: mixed, name: Name::*, type: string
 * }
 */
final class BetaServerToolUseBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    /** @var Name::* $name */
    #[Api(enum: Name::class)]
    public string $name;

    /**
     * You must use named parameters to construct this object.
     *
     * @param Name::* $name
     */
    final public function __construct(string $id, mixed $input, string $name)
    {
        self::introspect();

        $this->id = $id;
        $this->input = $input;
        $this->name = $name;
    }
}
