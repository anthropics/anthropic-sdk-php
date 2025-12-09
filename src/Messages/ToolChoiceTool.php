<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will use the specified tool with `tool_choice.name`.
 *
 * @phpstan-type ToolChoiceToolShape = array{
 *   name: string, type?: 'tool', disableParallelToolUse?: bool|null
 * }
 */
final class ToolChoiceTool implements BaseModel
{
    /** @use SdkModel<ToolChoiceToolShape> */
    use SdkModel;

    /** @var 'tool' $type */
    #[Required]
    public string $type = 'tool';

    /**
     * The name of the tool to use.
     */
    #[Required]
    public string $name;

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output exactly one tool use.
     */
    #[Optional('disable_parallel_tool_use')]
    public ?bool $disableParallelToolUse;

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
        ?bool $disableParallelToolUse = null
    ): self {
        $self = new self;

        $self['name'] = $name;

        null !== $disableParallelToolUse && $self['disableParallelToolUse'] = $disableParallelToolUse;

        return $self;
    }

    /**
     * The name of the tool to use.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output exactly one tool use.
     */
    public function withDisableParallelToolUse(
        bool $disableParallelToolUse
    ): self {
        $self = clone $this;
        $self['disableParallelToolUse'] = $disableParallelToolUse;

        return $self;
    }
}
