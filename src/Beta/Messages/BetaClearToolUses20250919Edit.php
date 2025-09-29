<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\ClearToolInputs;
use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\Trigger;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_clear_tool_uses20250919_edit = array{
 *   type: string,
 *   clearAtLeast?: BetaInputTokensClearAtLeast|null,
 *   clearToolInputs?: bool|null|list<string>,
 *   excludeTools?: list<string>|null,
 *   keep?: BetaToolUsesKeep,
 *   trigger?: BetaInputTokensTrigger|BetaToolUsesTrigger,
 * }
 */
final class BetaClearToolUses20250919Edit implements BaseModel
{
    /** @use SdkModel<beta_clear_tool_uses20250919_edit> */
    use SdkModel;

    #[Api]
    public string $type = 'clear_tool_uses_20250919';

    /**
     * Minimum number of tokens that must be cleared when triggered. Context will only be modified if at least this many tokens can be removed.
     */
    #[Api('clear_at_least', nullable: true, optional: true)]
    public ?BetaInputTokensClearAtLeast $clearAtLeast;

    /**
     * Whether to clear all tool inputs (bool) or specific tool inputs to clear (list).
     *
     * @var bool|list<string>|null $clearToolInputs
     */
    #[Api(
        'clear_tool_inputs',
        union: ClearToolInputs::class,
        nullable: true,
        optional: true,
    )]
    public bool|array|null $clearToolInputs;

    /**
     * Tool names whose uses are preserved from clearing.
     *
     * @var list<string>|null $excludeTools
     */
    #[Api('exclude_tools', list: 'string', nullable: true, optional: true)]
    public ?array $excludeTools;

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
     * @param bool|list<string>|null $clearToolInputs
     * @param list<string>|null $excludeTools
     */
    public static function with(
        ?BetaInputTokensClearAtLeast $clearAtLeast = null,
        bool|array|null $clearToolInputs = null,
        ?array $excludeTools = null,
        ?BetaToolUsesKeep $keep = null,
        BetaInputTokensTrigger|BetaToolUsesTrigger|null $trigger = null,
    ): self {
        $obj = new self;

        null !== $clearAtLeast && $obj->clearAtLeast = $clearAtLeast;
        null !== $clearToolInputs && $obj->clearToolInputs = $clearToolInputs;
        null !== $excludeTools && $obj->excludeTools = $excludeTools;
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
        $obj->clearAtLeast = $clearAtLeast;

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
        $obj->clearToolInputs = $clearToolInputs;

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
        $obj->excludeTools = $excludeTools;

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
