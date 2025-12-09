<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearThinking20251015EditShape = array{
 *   type?: 'clear_thinking_20251015',
 *   keep?: null|'all'|BetaThinkingTurns|BetaAllThinkingTurns,
 * }
 */
final class BetaClearThinking20251015Edit implements BaseModel
{
    /** @use SdkModel<BetaClearThinking20251015EditShape> */
    use SdkModel;

    /** @var 'clear_thinking_20251015' $type */
    #[Required]
    public string $type = 'clear_thinking_20251015';

    /**
     * Number of most recent assistant turns to keep thinking blocks for. Older turns will have their thinking blocks removed.
     *
     * @var 'all'|BetaThinkingTurns|BetaAllThinkingTurns|null $keep
     */
    #[Optional]
    public string|BetaThinkingTurns|BetaAllThinkingTurns|null $keep;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param 'all'|BetaThinkingTurns|array{
     *   type?: 'thinking_turns', value: int
     * }|BetaAllThinkingTurns|array{type?: 'all'} $keep
     */
    public static function with(
        string|BetaThinkingTurns|array|BetaAllThinkingTurns|null $keep = null
    ): self {
        $self = new self;

        null !== $keep && $self['keep'] = $keep;

        return $self;
    }

    /**
     * Number of most recent assistant turns to keep thinking blocks for. Older turns will have their thinking blocks removed.
     *
     * @param 'all'|BetaThinkingTurns|array{
     *   type?: 'thinking_turns', value: int
     * }|BetaAllThinkingTurns|array{type?: 'all'} $keep
     */
    public function withKeep(
        string|BetaThinkingTurns|array|BetaAllThinkingTurns $keep
    ): self {
        $self = clone $this;
        $self['keep'] = $keep;

        return $self;
    }
}
