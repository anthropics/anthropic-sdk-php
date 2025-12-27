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
 *   type: 'auto', disableParallelToolUse?: bool|null
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
        $self = new self;

        null !== $disableParallelToolUse && $self['disableParallelToolUse'] = $disableParallelToolUse;

        return $self;
    }

    /**
     * Whether to disable parallel tool use.
     *
     * Defaults to `false`. If set to `true`, the model will output at most one tool use.
     */
    public function withDisableParallelToolUse(
        bool $disableParallelToolUse
    ): self {
        $self = clone $this;
        $self['disableParallelToolUse'] = $disableParallelToolUse;

        return $self;
    }
}
