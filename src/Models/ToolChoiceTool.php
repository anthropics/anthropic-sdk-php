<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
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
    use Model;

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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $name,
        ?bool $disableParallelToolUse = null
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->name = $name;

        null !== $disableParallelToolUse && $this
            ->disableParallelToolUse = $disableParallelToolUse
        ;
    }
}
