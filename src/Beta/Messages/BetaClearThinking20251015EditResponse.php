<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearThinking20251015EditResponseShape = array{
 *   cleared_input_tokens: int,
 *   cleared_thinking_turns: int,
 *   type: 'clear_thinking_20251015',
 * }
 */
final class BetaClearThinking20251015EditResponse implements BaseModel
{
    /** @use SdkModel<BetaClearThinking20251015EditResponseShape> */
    use SdkModel;

    /**
     * The type of context management edit applied.
     *
     * @var 'clear_thinking_20251015' $type
     */
    #[Required]
    public string $type = 'clear_thinking_20251015';

    /**
     * Number of input tokens cleared by this edit.
     */
    #[Required]
    public int $cleared_input_tokens;

    /**
     * Number of thinking turns that were cleared.
     */
    #[Required]
    public int $cleared_thinking_turns;

    /**
     * `new BetaClearThinking20251015EditResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClearThinking20251015EditResponse::with(
     *   cleared_input_tokens: ..., cleared_thinking_turns: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClearThinking20251015EditResponse)
     *   ->withClearedInputTokens(...)
     *   ->withClearedThinkingTurns(...)
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
        int $cleared_input_tokens,
        int $cleared_thinking_turns
    ): self {
        $obj = new self;

        $obj['cleared_input_tokens'] = $cleared_input_tokens;
        $obj['cleared_thinking_turns'] = $cleared_thinking_turns;

        return $obj;
    }

    /**
     * Number of input tokens cleared by this edit.
     */
    public function withClearedInputTokens(int $clearedInputTokens): self
    {
        $obj = clone $this;
        $obj['cleared_input_tokens'] = $clearedInputTokens;

        return $obj;
    }

    /**
     * Number of thinking turns that were cleared.
     */
    public function withClearedThinkingTurns(int $clearedThinkingTurns): self
    {
        $obj = clone $this;
        $obj['cleared_thinking_turns'] = $clearedThinkingTurns;

        return $obj;
    }
}
