<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The model will use any available tools.
 */
final class BetaToolChoiceAny implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'any';

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
    public static function with(?bool $disableParallelToolUse = null): self
    {
        $obj = new self;

        null !== $disableParallelToolUse && $obj->disableParallelToolUse = $disableParallelToolUse;

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
