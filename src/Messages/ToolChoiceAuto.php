<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will automatically decide whether to use tools.
 *
 * @phpstan-type tool_choice_auto_alias = array{
 *   type: string, disableParallelToolUse?: bool
 * }
 */
final class ToolChoiceAuto implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'auto';

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output at most one tool use.
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
    public static function new(?bool $disableParallelToolUse = null): self
    {
        $obj = new self;

        null !== $disableParallelToolUse && $obj->disableParallelToolUse = $disableParallelToolUse;

        return $obj;
    }

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output at most one tool use.
     */
    public function setDisableParallelToolUse(
        bool $disableParallelToolUse
    ): self {
        $this->disableParallelToolUse = $disableParallelToolUse;

        return $this;
    }
}
