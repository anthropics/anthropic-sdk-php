<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearToolUses20250919EditResponseShape = array{
 *   cleared_input_tokens: int,
 *   cleared_tool_uses: int,
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
    #[Required]
    public int $cleared_input_tokens;

    /**
     * Number of tool uses that were cleared.
     */
    #[Required]
    public int $cleared_tool_uses;

    /**
     * `new BetaClearToolUses20250919EditResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClearToolUses20250919EditResponse::with(
     *   cleared_input_tokens: ..., cleared_tool_uses: ...
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
        int $cleared_input_tokens,
        int $cleared_tool_uses
    ): self {
        $obj = new self;

        $obj['cleared_input_tokens'] = $cleared_input_tokens;
        $obj['cleared_tool_uses'] = $cleared_tool_uses;

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
     * Number of tool uses that were cleared.
     */
    public function withClearedToolUses(int $clearedToolUses): self
    {
        $obj = clone $this;
        $obj['cleared_tool_uses'] = $clearedToolUses;

        return $obj;
    }
}
