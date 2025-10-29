<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearThinking20251015EditShape = array{
 *   type: string, keep?: string|BetaThinkingTurns|BetaAllThinkingTurns
 * }
 */
final class BetaClearThinking20251015Edit implements BaseModel
{
    /** @use SdkModel<BetaClearThinking20251015EditShape> */
    use SdkModel;

    #[Api]
    public string $type = 'clear_thinking_20251015';

    /**
     * Number of most recent assistant turns to keep thinking blocks for. Older turns will have their thinking blocks removed.
     */
    #[Api(optional: true)]
    public string|BetaThinkingTurns|BetaAllThinkingTurns|null $keep;

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
        string|BetaThinkingTurns|BetaAllThinkingTurns|null $keep = null
    ): self {
        $obj = new self;

        null !== $keep && $obj->keep = $keep;

        return $obj;
    }

    /**
     * Number of most recent assistant turns to keep thinking blocks for. Older turns will have their thinking blocks removed.
     */
    public function withKeep(
        string|BetaThinkingTurns|BetaAllThinkingTurns $keep
    ): self {
        $obj = clone $this;
        $obj->keep = $keep;

        return $obj;
    }
}
