<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaThinkingTurnsShape = array{
 *   type?: 'thinking_turns', value: int
 * }
 */
final class BetaThinkingTurns implements BaseModel
{
    /** @use SdkModel<BetaThinkingTurnsShape> */
    use SdkModel;

    /** @var 'thinking_turns' $type */
    #[Required]
    public string $type = 'thinking_turns';

    #[Required]
    public int $value;

    /**
     * `new BetaThinkingTurns()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaThinkingTurns::with(value: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaThinkingTurns)->withValue(...)
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
    public static function with(int $value): self
    {
        $self = new self;

        $self['value'] = $value;

        return $self;
    }

    public function withValue(int $value): self
    {
        $self = clone $this;
        $self['value'] = $value;

        return $self;
    }
}
