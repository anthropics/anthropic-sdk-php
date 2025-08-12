<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will use the specified tool with `tool_choice.name`.
 *
 * @phpstan-type tool_choice_tool_alias = array{
 *   name: string, type: string, disableParallelToolUse?: bool
 * }
 */
final class ToolChoiceTool implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'tool';

    /**
     * The name of the tool to use.
     */
    #[Api]
    public string $name;

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output exactly one tool use.
     */
    #[Api('disable_parallel_tool_use', optional: true)]
    public ?bool $disableParallelToolUse;

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
    public static function from(
        string $name,
        ?bool $disableParallelToolUse = null
    ): self {
        $obj = new self;

        $obj->name = $name;

        null !== $disableParallelToolUse && $obj->disableParallelToolUse = $disableParallelToolUse;

        return $obj;
    }

    /**
     * The name of the tool to use.
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output exactly one tool use.
     */
    public function setDisableParallelToolUse(
        bool $disableParallelToolUse
    ): self {
        $this->disableParallelToolUse = $disableParallelToolUse;

        return $this;
    }
}
