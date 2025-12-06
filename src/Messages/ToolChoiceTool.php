<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will use the specified tool with `tool_choice.name`.
 *
 * @phpstan-type ToolChoiceToolShape = array{
 *   name: string, type: 'tool', disable_parallel_tool_use?: bool|null
 * }
 */
final class ToolChoiceTool implements BaseModel
{
    /** @use SdkModel<ToolChoiceToolShape> */
    use SdkModel;

    /** @var 'tool' $type */
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
    #[Api(optional: true)]
    public ?bool $disable_parallel_tool_use;

    /**
     * `new ToolChoiceTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ToolChoiceTool::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ToolChoiceTool)->withName(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $name,
        ?bool $disable_parallel_tool_use = null
    ): self {
        $obj = new self;

        $obj['name'] = $name;

        null !== $disable_parallel_tool_use && $obj['disable_parallel_tool_use'] = $disable_parallel_tool_use;

        return $obj;
    }

    /**
     * The name of the tool to use.
     */
    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj['name'] = $name;

        return $obj;
    }

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output exactly one tool use.
     */
    public function withDisableParallelToolUse(
        bool $disableParallelToolUse
    ): self {
        $obj = clone $this;
        $obj['disable_parallel_tool_use'] = $disableParallelToolUse;

        return $obj;
    }
}
