<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContextManagementResponse\AppliedEdit;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaContextManagementResponseShape = array{
 *   applied_edits: list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse>,
 * }
 */
final class BetaContextManagementResponse implements BaseModel
{
    /** @use SdkModel<BetaContextManagementResponseShape> */
    use SdkModel;

    /**
     * List of context management edits that were applied.
     *
     * @var list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse> $applied_edits
     */
    #[Api(list: AppliedEdit::class)]
    public array $applied_edits;

    /**
     * `new BetaContextManagementResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContextManagementResponse::with(applied_edits: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaContextManagementResponse)->withAppliedEdits(...)
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
     *
     * @param list<BetaClearToolUses20250919EditResponse|array{
     *   cleared_input_tokens: int,
     *   cleared_tool_uses: int,
     *   type: 'clear_tool_uses_20250919',
     * }|BetaClearThinking20251015EditResponse|array{
     *   cleared_input_tokens: int,
     *   cleared_thinking_turns: int,
     *   type: 'clear_thinking_20251015',
     * }> $applied_edits
     */
    public static function with(array $applied_edits): self
    {
        $obj = new self;

        $obj['applied_edits'] = $applied_edits;

        return $obj;
    }

    /**
     * List of context management edits that were applied.
     *
     * @param list<BetaClearToolUses20250919EditResponse|array{
     *   cleared_input_tokens: int,
     *   cleared_tool_uses: int,
     *   type: 'clear_tool_uses_20250919',
     * }|BetaClearThinking20251015EditResponse|array{
     *   cleared_input_tokens: int,
     *   cleared_thinking_turns: int,
     *   type: 'clear_thinking_20251015',
     * }> $appliedEdits
     */
    public function withAppliedEdits(array $appliedEdits): self
    {
        $obj = clone $this;
        $obj['applied_edits'] = $appliedEdits;

        return $obj;
    }
}
