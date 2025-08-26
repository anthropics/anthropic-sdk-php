<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will use the specified tool with `tool_choice.name`.
 *
 * @phpstan-type beta_tool_choice_tool = array{
 *   name: string, type: string, disableParallelToolUse?: bool|null
 * }
 */
final class BetaToolChoiceTool implements BaseModel
{
    /** @use SdkModel<beta_tool_choice_tool> */
    use SdkModel;

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
     * `new BetaToolChoiceTool()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaToolChoiceTool::with(name: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaToolChoiceTool)->withName(...)
     * ```
     */
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
    public static function with(
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
    public function withName(string $name): self
    {
        $obj = clone $this;
        $obj->name = $name;

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
        $obj->disableParallelToolUse = $disableParallelToolUse;

        return $obj;
    }
}
