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
 * @phpstan-import-type BetaInputTokensClearAtLeastShape from \Anthropic\Beta\Messages\BetaInputTokensClearAtLeast
 * @phpstan-import-type ClearToolInputsShape from \Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\ClearToolInputs
 * @phpstan-import-type BetaToolUsesKeepShape from \Anthropic\Beta\Messages\BetaToolUsesKeep
 * @phpstan-import-type TriggerShape from \Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\Trigger
 *
 * @phpstan-type BetaClearToolUses20250919EditShape = array{
 *   type: 'clear_tool_uses_20250919',
 *   clearAtLeast?: null|BetaInputTokensClearAtLeast|BetaInputTokensClearAtLeastShape,
 *   clearToolInputs?: ClearToolInputsShape|null,
 *   excludeTools?: list<string>|null,
 *   keep?: null|BetaToolUsesKeep|BetaToolUsesKeepShape,
 *   trigger?: null|TriggerShape|BetaInputTokensTrigger|BetaToolUsesTrigger,
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
     * @param BetaInputTokensClearAtLeastShape|null $clearAtLeast
     * @param ClearToolInputsShape|null $clearToolInputs
     * @param list<string>|null $excludeTools
     * @param BetaToolUsesKeepShape $keep
     * @param TriggerShape $trigger
     */
    public static function with(
        BetaInputTokensClearAtLeast|array|null $clearAtLeast = null,
        bool|array|null $clearToolInputs = null,
        ?array $excludeTools = null,
        BetaToolUsesKeep|array|null $keep = null,
        BetaInputTokensTrigger|array|BetaToolUsesTrigger|null $trigger = null,
    ): self {
        $self = new self;

        null !== $clearAtLeast && $self['clearAtLeast'] = $clearAtLeast;
        null !== $clearToolInputs && $self['clearToolInputs'] = $clearToolInputs;
        null !== $excludeTools && $self['excludeTools'] = $excludeTools;
        null !== $keep && $self['keep'] = $keep;
        null !== $trigger && $self['trigger'] = $trigger;

        return $self;
    }

    /**
     * Minimum number of tokens that must be cleared when triggered. Context will only be modified if at least this many tokens can be removed.
     *
     * @param BetaInputTokensClearAtLeastShape|null $clearAtLeast
     */
    public function withClearAtLeast(
        BetaInputTokensClearAtLeast|array|null $clearAtLeast
    ): self {
        $self = clone $this;
        $self['clearAtLeast'] = $clearAtLeast;

        return $self;
    }

    /**
     * Whether to clear all tool inputs (bool) or specific tool inputs to clear (list).
     *
     * @param ClearToolInputsShape|null $clearToolInputs
     */
    public function withClearToolInputs(bool|array|null $clearToolInputs): self
    {
        $self = clone $this;
        $self['clearToolInputs'] = $clearToolInputs;

        return $self;
    }

    /**
     * Tool names whose uses are preserved from clearing.
     *
     * @param list<string>|null $excludeTools
     */
    public function withExcludeTools(?array $excludeTools): self
    {
        $self = clone $this;
        $self['excludeTools'] = $excludeTools;

        return $self;
    }

    /**
     * Number of tool uses to retain in the conversation.
     *
     * @param BetaToolUsesKeepShape $keep
     */
    public function withKeep(BetaToolUsesKeep|array $keep): self
    {
        $self = clone $this;
        $self['keep'] = $keep;

        return $self;
    }

    /**
     * Condition that triggers the context management strategy.
     *
     * @param TriggerShape $trigger
     */
    public function withTrigger(
        BetaInputTokensTrigger|array|BetaToolUsesTrigger $trigger
    ): self {
        $self = clone $this;
        $self['trigger'] = $trigger;

        return $self;
    }
}
