<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContextManagementConfig;

use Anthropic\Beta\Messages\BetaAllThinkingTurns;
use Anthropic\Beta\Messages\BetaClearThinking20251015Edit;
use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit;
use Anthropic\Beta\Messages\BetaCompact20260112Edit;
use Anthropic\Beta\Messages\BetaContextManagementConfig\Edit\Type;
use Anthropic\Beta\Messages\BetaInputTokensClearAtLeast;
use Anthropic\Beta\Messages\BetaInputTokensTrigger;
use Anthropic\Beta\Messages\BetaThinkingTurns;
use Anthropic\Beta\Messages\BetaToolUsesKeep;
use Anthropic\Beta\Messages\BetaToolUsesTrigger;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaClearToolUses20250919EditShape from \Anthropic\Beta\Messages\BetaClearToolUses20250919Edit
 * @phpstan-import-type BetaClearThinking20251015EditShape from \Anthropic\Beta\Messages\BetaClearThinking20251015Edit
 * @phpstan-import-type BetaCompact20260112EditShape from \Anthropic\Beta\Messages\BetaCompact20260112Edit
 * @phpstan-import-type BetaInputTokensClearAtLeastShape from \Anthropic\Beta\Messages\BetaInputTokensClearAtLeast
 * @phpstan-import-type ClearToolInputsShape from \Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\ClearToolInputs
 * @phpstan-import-type BetaToolUsesKeepShape from \Anthropic\Beta\Messages\BetaToolUsesKeep
 * @phpstan-import-type KeepShape from \Anthropic\Beta\Messages\BetaClearThinking20251015Edit\Keep
 * @phpstan-import-type TriggerShape from \Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\Trigger
 * @phpstan-import-type BetaInputTokensTriggerShape from \Anthropic\Beta\Messages\BetaInputTokensTrigger
 *
 * @phpstan-type EditVariants = BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit|BetaCompact20260112Edit
 * @phpstan-type EditShape = EditVariants|BetaClearToolUses20250919EditShape|BetaClearThinking20251015EditShape|BetaCompact20260112EditShape
 */
final class Edit implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'clear_tool_uses_20250919' => BetaClearToolUses20250919Edit::class,
            'clear_thinking_20251015' => BetaClearThinking20251015Edit::class,
            'compact_20260112' => BetaCompact20260112Edit::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaInputTokensClearAtLeast|BetaInputTokensClearAtLeastShape|null $clearAtLeast
     * @param ClearToolInputsShape|null $clearToolInputs
     * @param list<string>|null $excludeTools
     * @param ($type is Type::CLEAR_TOOL_USES_20250919|'clear_tool_uses_20250919' ? BetaToolUsesKeep|BetaToolUsesKeepShape|null : KeepShape|null) $keep
     * @param ($type is Type::CLEAR_TOOL_USES_20250919|'clear_tool_uses_20250919' ? TriggerShape|null : BetaInputTokensTrigger|BetaInputTokensTriggerShape|null) $trigger
     *
     * @return ($type is Type::CLEAR_TOOL_USES_20250919|'clear_tool_uses_20250919' ? BetaClearToolUses20250919Edit : ($type is Type::CLEAR_THINKING_20251015|'clear_thinking_20251015' ? BetaClearThinking20251015Edit : ($type is Type::COMPACT_20260112|'compact_20260112' ? BetaCompact20260112Edit : BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit|BetaCompact20260112Edit)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaInputTokensClearAtLeast|array|null $clearAtLeast = null,
        bool|array|null $clearToolInputs = null,
        ?array $excludeTools = null,
        string|BetaToolUsesKeep|array|BetaThinkingTurns|BetaAllThinkingTurns|null $keep = null,
        BetaInputTokensTrigger|array|BetaToolUsesTrigger|null $trigger = null,
        ?string $instructions = null,
        ?bool $pauseAfterCompaction = null,
    ): BetaClearToolUses20250919Edit|BetaClearThinking20251015Edit|BetaCompact20260112Edit {
        return match ($type) {
            Type::CLEAR_TOOL_USES_20250919, 'clear_tool_uses_20250919' => BetaClearToolUses20250919Edit::with(
                clearAtLeast: $clearAtLeast,
                clearToolInputs: $clearToolInputs,
                excludeTools: $excludeTools,
                keep: $keep,
                trigger: $trigger,
            ),
            Type::CLEAR_THINKING_20251015, 'clear_thinking_20251015' => BetaClearThinking20251015Edit::with(
                // @phpstan-ignore argument.type
                keep: $keep,
            ),
            Type::COMPACT_20260112, 'compact_20260112' => BetaCompact20260112Edit::with(
                instructions: $instructions,
                pauseAfterCompaction: $pauseAfterCompaction,
                // @phpstan-ignore argument.type
                trigger: $trigger,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
