<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_clear_tool_uses20250919_edit_response = array{
 *   clearedInputTokens: int, clearedToolUses: int, type: string
 * }
 */
final class BetaClearToolUses20250919EditResponse implements BaseModel
{
    /** @use SdkModel<beta_clear_tool_uses20250919_edit_response> */
    use SdkModel;

    /**
     * The type of context management edit applied.
     */
    #[Api]
    public string $type = 'clear_tool_uses_20250919';

    /**
     * Number of input tokens cleared by this edit.
     */
    #[Api('cleared_input_tokens')]
    public int $clearedInputTokens;

    /**
     * Number of tool uses that were cleared.
     */
    #[Api('cleared_tool_uses')]
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
        $obj = new self;

        $obj->clearedInputTokens = $clearedInputTokens;
        $obj->clearedToolUses = $clearedToolUses;

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
     * Number of tool uses that were cleared.
     */
    public function withClearedToolUses(int $clearedToolUses): self
    {
        $obj = clone $this;
        $obj->clearedToolUses = $clearedToolUses;

        return $obj;
    }
}
