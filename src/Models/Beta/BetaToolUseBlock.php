<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_tool_use_block_alias = array{
 *   id: string, input: mixed, name: string, type: string
 * }
 */
final class BetaToolUseBlock implements BaseModel
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
    public static function new(string $id, mixed $input, string $name): self
    {
        $obj = new self;

        $obj->id = $id;
        $obj->input = $input;
        $obj->name = $name;

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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
