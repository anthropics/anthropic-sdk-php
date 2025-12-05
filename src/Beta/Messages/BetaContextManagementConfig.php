<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContextManagementConfig\Edit;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaContextManagementConfigShape = array{
 *   edits?: list<BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit>|null
 * }
 */
final class BetaContextManagementConfig implements BaseModel
{
    /** @use SdkModel<BetaContextManagementConfigShape> */
    use SdkModel;

    /**
     * List of context management edits to apply.
     *
     * @var list<BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit>|null $edits
     */
    #[Api(list: Edit::class, optional: true)]
    public ?array $edits;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaClearToolUses20250919Edit|array{
     *   type: 'clear_tool_uses_20250919',
     *   clear_at_least?: BetaInputTokensClearAtLeast|null,
     *   clear_tool_inputs?: bool|list<string>|null,
     *   exclude_tools?: list<string>|null,
     *   keep?: BetaToolUsesKeep|null,
     *   trigger?: BetaInputTokensTrigger|BetaToolUsesTrigger|null,
     * }|BetaClearThinking20251015Edit|array{
     *   type: 'clear_thinking_20251015',
     *   keep?: 'all'|BetaThinkingTurns|BetaAllThinkingTurns|null,
     * }> $edits
     */
    public static function with(?array $edits = null): self
    {
        $obj = new self;

        null !== $edits && $obj['edits'] = $edits;

        return $obj;
    }

    /**
     * List of context management edits to apply.
     *
     * @param list<BetaClearToolUses20250919Edit|array{
     *   type: 'clear_tool_uses_20250919',
     *   clear_at_least?: BetaInputTokensClearAtLeast|null,
     *   clear_tool_inputs?: bool|list<string>|null,
     *   exclude_tools?: list<string>|null,
     *   keep?: BetaToolUsesKeep|null,
     *   trigger?: BetaInputTokensTrigger|BetaToolUsesTrigger|null,
     * }|BetaClearThinking20251015Edit|array{
     *   type: 'clear_thinking_20251015',
     *   keep?: 'all'|BetaThinkingTurns|BetaAllThinkingTurns|null,
     * }> $edits
     */
    public function withEdits(array $edits): self
    {
        $obj = clone $this;
        $obj['edits'] = $edits;

        return $obj;
    }
}
