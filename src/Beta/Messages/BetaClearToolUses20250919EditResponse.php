<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearToolUses20250919EditResponseShape = array{
 *   clearedInputTokens: int,
 *   clearedToolUses: int,
 *   type: 'clear_tool_uses_20250919',
 * }
 */
final class BetaClearToolUses20250919EditResponse implements BaseModel
{
    /** @use SdkModel<BetaClearToolUses20250919EditResponseShape> */
    use SdkModel;

    /**
     * The type of context management edit applied.
     *
     * @var 'clear_tool_uses_20250919' $type
     */
    #[Required]
    public string $type = 'clear_tool_uses_20250919';

    /**
     * Number of input tokens cleared by this edit.
     */
    #[Required('cleared_input_tokens')]
    public int $clearedInputTokens;

    /**
     * Number of tool uses that were cleared.
     */
    #[Required('cleared_tool_uses')]
    public int $clearedToolUses;

    /**
     * `new BetaClearToolUses20250919EditResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClearToolUses20250919EditResponse::with(
     *   clearedInputTokens: ..., clearedToolUses: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClearToolUses20250919EditResponse)
     *   ->withClearedInputTokens(...)
     *   ->withClearedToolUses(...)
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
        int $clearedToolUses
    ): self {
        $self = new self;

        $self['clearedInputTokens'] = $clearedInputTokens;
        $self['clearedToolUses'] = $clearedToolUses;

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
     * Number of tool uses that were cleared.
     */
    public function withClearedToolUses(int $clearedToolUses): self
    {
        $self = clone $this;
        $self['clearedToolUses'] = $clearedToolUses;

        return $self;
    }
}
