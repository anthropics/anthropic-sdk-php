<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\ClearToolInputs;
use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\Trigger;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearToolUses20250919EditShape = array{
 *   type?: 'clear_tool_uses_20250919',
 *   clearAtLeast?: BetaInputTokensClearAtLeast|null,
 *   clearToolInputs?: bool|null|list<string>,
 *   excludeTools?: list<string>|null,
 *   keep?: BetaToolUsesKeep|null,
 *   trigger?: null|BetaInputTokensTrigger|BetaToolUsesTrigger,
 * }
 */
final class BetaClearToolUses20250919Edit implements BaseModel
{
    /** @use SdkModel<BetaClearToolUses20250919EditShape> */
    use SdkModel;

    /** @var 'clear_tool_uses_20250919' $type */
    #[Required]
    public string $type = 'clear_tool_uses_20250919';

    /**
     * Minimum number of tokens that must be cleared when triggered. Context will only be modified if at least this many tokens can be removed.
     */
    #[Optional('clear_at_least', nullable: true)]
    public ?BetaInputTokensClearAtLeast $clearAtLeast;

    /**
     * Whether to clear all tool inputs (bool) or specific tool inputs to clear (list).
     *
     * @var bool|list<string>|null $clearToolInputs
     */
    #[Optional(
        'clear_tool_inputs',
        union: ClearToolInputs::class,
        nullable: true
    )]
    public bool|array|null $clearToolInputs;

    /**
     * Tool names whose uses are preserved from clearing.
     *
     * @var list<string>|null $excludeTools
     */
    #[Optional('exclude_tools', list: 'string', nullable: true)]
    public ?array $excludeTools;

    /**
     * Number of tool uses to retain in the conversation.
     */
    #[Optional]
    public ?BetaToolUsesKeep $keep;

    /**
     * Condition that triggers the context management strategy.
     */
    #[Optional(union: Trigger::class)]
    public BetaInputTokensTrigger|BetaToolUsesTrigger|null $trigger;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaInputTokensClearAtLeast|array{
     *   type?: 'input_tokens', value: int
     * }|null $clearAtLeast
     * @param bool|list<string>|null $clearToolInputs
     * @param list<string>|null $excludeTools
     * @param BetaToolUsesKeep|array{type?: 'tool_uses', value: int} $keep
     * @param BetaInputTokensTrigger|array{
     *   type?: 'input_tokens', value: int
     * }|BetaToolUsesTrigger|array{type?: 'tool_uses', value: int} $trigger
     */
    public static function with(
        BetaInputTokensClearAtLeast|array|null $clearAtLeast = null,
        bool|array|null $clearToolInputs = null,
        ?array $excludeTools = null,
        BetaToolUsesKeep|array|null $keep = null,
        BetaInputTokensTrigger|array|BetaToolUsesTrigger|null $trigger = null,
    ): self {
        $obj = new self;

        null !== $clearAtLeast && $obj['clearAtLeast'] = $clearAtLeast;
        null !== $clearToolInputs && $obj['clearToolInputs'] = $clearToolInputs;
        null !== $excludeTools && $obj['excludeTools'] = $excludeTools;
        null !== $keep && $obj['keep'] = $keep;
        null !== $trigger && $obj['trigger'] = $trigger;

        return $obj;
    }

    /**
     * Minimum number of tokens that must be cleared when triggered. Context will only be modified if at least this many tokens can be removed.
     *
     * @param BetaInputTokensClearAtLeast|array{
     *   type?: 'input_tokens', value: int
     * }|null $clearAtLeast
     */
    public function withClearAtLeast(
        BetaInputTokensClearAtLeast|array|null $clearAtLeast
    ): self {
        $obj = clone $this;
        $obj['clearAtLeast'] = $clearAtLeast;

        return $obj;
    }

    /**
     * Whether to clear all tool inputs (bool) or specific tool inputs to clear (list).
     *
     * @param bool|list<string>|null $clearToolInputs
     */
    public function withClearToolInputs(bool|array|null $clearToolInputs): self
    {
        $obj = clone $this;
        $obj['clearToolInputs'] = $clearToolInputs;

        return $obj;
    }

    /**
     * Tool names whose uses are preserved from clearing.
     *
     * @param list<string>|null $excludeTools
     */
    public function withExcludeTools(?array $excludeTools): self
    {
        $obj = clone $this;
        $obj['excludeTools'] = $excludeTools;

        return $obj;
    }

    /**
     * Number of tool uses to retain in the conversation.
     *
     * @param BetaToolUsesKeep|array{type?: 'tool_uses', value: int} $keep
     */
    public function withKeep(BetaToolUsesKeep|array $keep): self
    {
        $obj = clone $this;
        $obj['keep'] = $keep;

        return $obj;
    }

    /**
     * Condition that triggers the context management strategy.
     *
     * @param BetaInputTokensTrigger|array{
     *   type?: 'input_tokens', value: int
     * }|BetaToolUsesTrigger|array{type?: 'tool_uses', value: int} $trigger
     */
    public function withTrigger(
        BetaInputTokensTrigger|array|BetaToolUsesTrigger $trigger
    ): self {
        $obj = clone $this;
        $obj['trigger'] = $trigger;

        return $obj;
    }
}
