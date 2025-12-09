<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContextManagementResponse\AppliedEdit;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaContextManagementResponseShape = array{
 *   appliedEdits: list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse>,
 * }
 */
final class BetaContextManagementResponse implements BaseModel
{
    /** @use SdkModel<BetaContextManagementResponseShape> */
    use SdkModel;

    /**
     * List of context management edits that were applied.
     *
     * @var list<BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse> $appliedEdits
     */
    #[Required('applied_edits', list: AppliedEdit::class)]
    public array $appliedEdits;

    /**
     * `new BetaContextManagementResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaContextManagementResponse::with(appliedEdits: ...)
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
     *   clearedInputTokens: int,
     *   clearedToolUses: int,
     *   type?: 'clear_tool_uses_20250919',
     * }|BetaClearThinking20251015EditResponse|array{
     *   clearedInputTokens: int,
     *   clearedThinkingTurns: int,
     *   type?: 'clear_thinking_20251015',
     * }> $appliedEdits
     */
    public static function with(array $appliedEdits): self
    {
        $obj = new self;

        $obj['appliedEdits'] = $appliedEdits;

        return $obj;
    }

    /**
     * List of context management edits that were applied.
     *
     * @param list<BetaClearToolUses20250919EditResponse|array{
     *   clearedInputTokens: int,
     *   clearedToolUses: int,
     *   type?: 'clear_tool_uses_20250919',
     * }|BetaClearThinking20251015EditResponse|array{
     *   clearedInputTokens: int,
     *   clearedThinkingTurns: int,
     *   type?: 'clear_thinking_20251015',
     * }> $appliedEdits
     */
    public function withAppliedEdits(array $appliedEdits): self
    {
        $obj = clone $this;
        $obj['appliedEdits'] = $appliedEdits;

        return $obj;
    }
}
