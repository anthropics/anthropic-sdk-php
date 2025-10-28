<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_clear_thinking20251015_edit_response = array{
 *   clearedInputTokens: int, clearedThinkingTurns: int, type: string
 * }
 */
final class BetaClearThinking20251015EditResponse implements BaseModel
{
    /** @use SdkModel<beta_clear_thinking20251015_edit_response> */
    use SdkModel;

    /**
     * The type of context management edit applied.
     */
    #[Api]
    public string $type = 'clear_thinking_20251015';

    /**
     * Number of input tokens cleared by this edit.
     */
    #[Api('cleared_input_tokens')]
    public int $clearedInputTokens;

    /**
     * Number of thinking turns that were cleared.
     */
    #[Api('cleared_thinking_turns')]
    public int $clearedThinkingTurns;

    /**
     * `new BetaClearThinking20251015EditResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClearThinking20251015EditResponse::with(
     *   clearedInputTokens: ..., clearedThinkingTurns: ...
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
        int $clearedInputTokens,
        int $clearedThinkingTurns
    ): self {
        $obj = new self;

        $obj->clearedInputTokens = $clearedInputTokens;
        $obj->clearedThinkingTurns = $clearedThinkingTurns;

        return $obj;
    }

    /**
     * Number of input tokens cleared by this edit.
     */
    public function withClearedInputTokens(int $clearedInputTokens): self
    {
        $obj = clone $this;
        $obj->clearedInputTokens = $clearedInputTokens;

        return $obj;
    }

    /**
     * Number of thinking turns that were cleared.
     */
    public function withClearedThinkingTurns(int $clearedThinkingTurns): self
    {
        $obj = clone $this;
        $obj->clearedThinkingTurns = $clearedThinkingTurns;

        return $obj;
    }
}
