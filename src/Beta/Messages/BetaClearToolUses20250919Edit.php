<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\ClearToolInputs;
use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\Trigger;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaClearToolUses20250919EditShape = array{
 *   type: 'clear_tool_uses_20250919',
 *   clear_at_least?: BetaInputTokensClearAtLeast|null,
 *   clear_tool_inputs?: bool|null|list<string>,
 *   exclude_tools?: list<string>|null,
 *   keep?: BetaToolUsesKeep|null,
 *   trigger?: null|BetaInputTokensTrigger|BetaToolUsesTrigger,
 * }
 */
final class BetaClearToolUses20250919Edit implements BaseModel
{
    /** @use SdkModel<BetaClearToolUses20250919EditShape> */
    use SdkModel;

    /** @var 'clear_tool_uses_20250919' $type */
    #[Api]
    public string $type = 'clear_tool_uses_20250919';

    /**
     * Minimum number of tokens that must be cleared when triggered. Context will only be modified if at least this many tokens can be removed.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaInputTokensClearAtLeast $clear_at_least;

    /**
     * Whether to clear all tool inputs (bool) or specific tool inputs to clear (list).
     *
     * @var bool|list<string>|null $clear_tool_inputs
     */
    #[Api(union: ClearToolInputs::class, nullable: true, optional: true)]
    public bool|array|null $clear_tool_inputs;

    /**
     * Tool names whose uses are preserved from clearing.
     *
     * @var list<string>|null $exclude_tools
     */
    #[Api(list: 'string', nullable: true, optional: true)]
    public ?array $exclude_tools;

    /**
     * Number of tool uses to retain in the conversation.
     */
    #[Api(optional: true)]
    public ?BetaToolUsesKeep $keep;

    /**
     * Condition that triggers the context management strategy.
     */
    #[Api(union: Trigger::class, optional: true)]
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
     * @param bool|list<string>|null $clear_tool_inputs
     * @param list<string>|null $exclude_tools
     */
    public static function with(
        ?BetaInputTokensClearAtLeast $clear_at_least = null,
        bool|array|null $clear_tool_inputs = null,
        ?array $exclude_tools = null,
        ?BetaToolUsesKeep $keep = null,
        BetaInputTokensTrigger|BetaToolUsesTrigger|null $trigger = null,
    ): self {
        $obj = new self;

        null !== $clear_at_least && $obj->clear_at_least = $clear_at_least;
        null !== $clear_tool_inputs && $obj->clear_tool_inputs = $clear_tool_inputs;
        null !== $exclude_tools && $obj->exclude_tools = $exclude_tools;
        null !== $keep && $obj->keep = $keep;
        null !== $trigger && $obj->trigger = $trigger;

        return $obj;
    }

    /**
     * Minimum number of tokens that must be cleared when triggered. Context will only be modified if at least this many tokens can be removed.
     */
    public function withClearAtLeast(
        ?BetaInputTokensClearAtLeast $clearAtLeast
    ): self {
        $obj = clone $this;
        $obj->clear_at_least = $clearAtLeast;

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
        $obj->clear_tool_inputs = $clearToolInputs;

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
        $obj->exclude_tools = $excludeTools;

        return $obj;
    }

    /**
     * Number of tool uses to retain in the conversation.
     */
    public function withKeep(BetaToolUsesKeep $keep): self
    {
        $obj = clone $this;
        $obj->keep = $keep;

        return $obj;
    }

    /**
     * Condition that triggers the context management strategy.
     */
    public function withTrigger(
        BetaInputTokensTrigger|BetaToolUsesTrigger $trigger
    ): self {
        $obj = clone $this;
        $obj->trigger = $trigger;

        return $obj;
    }
}
