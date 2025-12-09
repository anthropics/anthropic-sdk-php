<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will use any available tools.
 *
 * @phpstan-type ToolChoiceAnyShape = array{
 *   type?: 'any', disableParallelToolUse?: bool|null
 * }
 */
final class ToolChoiceAny implements BaseModel
{
    /** @use SdkModel<ToolChoiceAnyShape> */
    use SdkModel;

    /** @var 'any' $type */
    #[Required]
    public string $type = 'any';

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output exactly one tool use.
     */
    #[Optional('disable_parallel_tool_use')]
    public ?bool $disableParallelToolUse;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $disableParallelToolUse = null): self
    {
        $obj = new self;

        null !== $disableParallelToolUse && $obj['disableParallelToolUse'] = $disableParallelToolUse;

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
        $obj['disableParallelToolUse'] = $disableParallelToolUse;

        return $obj;
    }
}
