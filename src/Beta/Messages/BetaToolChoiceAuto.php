<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will automatically decide whether to use tools.
 *
 * @phpstan-type BetaToolChoiceAutoShape = array{
 *   type: 'auto', disable_parallel_tool_use?: bool|null
 * }
 */
final class BetaToolChoiceAuto implements BaseModel
{
    /** @use SdkModel<BetaToolChoiceAutoShape> */
    use SdkModel;

    /** @var 'auto' $type */
    #[Required]
    public string $type = 'auto';

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output at most one tool use.
     */
    #[Optional]
    public ?bool $disable_parallel_tool_use;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(?bool $disable_parallel_tool_use = null): self
    {
        $obj = new self;

        null !== $disable_parallel_tool_use && $obj['disable_parallel_tool_use'] = $disable_parallel_tool_use;

        return $obj;
    }

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output at most one tool use.
     */
    public function withDisableParallelToolUse(
        bool $disableParallelToolUse
    ): self {
        $obj = clone $this;
        $obj['disable_parallel_tool_use'] = $disableParallelToolUse;

        return $obj;
    }
}
