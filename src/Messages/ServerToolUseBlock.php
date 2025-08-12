<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type server_tool_use_block_alias = array{
 *   id: string, input: mixed, name: string, type: string
 * }
 */
final class ServerToolUseBlock implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $name = 'web_search';

    #[Api]
    public string $type = 'server_tool_use';

    #[Api]
    public string $id;

    #[Api]
    public mixed $input;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function from(string $id, mixed $input): self
    {
        $obj = new self;

        $obj->id = $id;
        $obj->input = $input;

        return $obj;
    }

    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setInput(mixed $input): self
    {
        $this->input = $input;

        return $this;
    }
}
