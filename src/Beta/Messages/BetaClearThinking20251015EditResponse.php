<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearThinking20251015EditResponseShape = array{
 *   clearedInputTokens: int,
 *   clearedThinkingTurns: int,
 *   type?: 'clear_thinking_20251015',
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
    #[Required('cleared_input_tokens')]
    public int $clearedInputTokens;

    /**
     * Number of thinking turns that were cleared.
     */
    #[Required('cleared_thinking_turns')]
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
        $self = new self;

        $self['clearedInputTokens'] = $clearedInputTokens;
        $self['clearedThinkingTurns'] = $clearedThinkingTurns;

        return $self;
    }

    /**
     * Number of input tokens cleared by this edit.
     */
    public function withClearedInputTokens(int $clearedInputTokens): self
    {
        $self = clone $this;
        $self['clearedInputTokens'] = $clearedInputTokens;

        return $self;
    }

    /**
     * Number of thinking turns that were cleared.
     */
    public function withClearedThinkingTurns(int $clearedThinkingTurns): self
    {
        $self = clone $this;
        $self['clearedThinkingTurns'] = $clearedThinkingTurns;

        return $self;
    }
}
