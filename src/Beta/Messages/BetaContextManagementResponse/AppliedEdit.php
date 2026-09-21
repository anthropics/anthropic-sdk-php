<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContextManagementResponse;

use Anthropic\Beta\Messages\BetaClearThinking20251015EditResponse;
use Anthropic\Beta\Messages\BetaClearToolUses20250919EditResponse;
use Anthropic\Beta\Messages\BetaContextManagementResponse\AppliedEdit\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaClearToolUses20250919EditResponseShape from \Anthropic\Beta\Messages\BetaClearToolUses20250919EditResponse
 * @phpstan-import-type BetaClearThinking20251015EditResponseShape from \Anthropic\Beta\Messages\BetaClearThinking20251015EditResponse
 *
 * @phpstan-type AppliedEditVariants = BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse
 * @phpstan-type AppliedEditShape = AppliedEditVariants|BetaClearToolUses20250919EditResponseShape|BetaClearThinking20251015EditResponseShape
 */
final class AppliedEdit implements ConverterSource
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
            'clear_tool_uses_20250919' => BetaClearToolUses20250919EditResponse::class,
            'clear_thinking_20251015' => BetaClearThinking20251015EditResponse::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CLEAR_TOOL_USES_20250919|'clear_tool_uses_20250919' ? BetaClearToolUses20250919EditResponse : ($type is Type::CLEAR_THINKING_20251015|'clear_thinking_20251015' ? BetaClearThinking20251015EditResponse : BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        int $clearedInputTokens,
        ?int $clearedToolUses = null,
        ?int $clearedThinkingTurns = null,
    ): BetaClearToolUses20250919EditResponse|BetaClearThinking20251015EditResponse {
        return match ($type) {
            Type::CLEAR_TOOL_USES_20250919, 'clear_tool_uses_20250919' => BetaClearToolUses20250919EditResponse::with(
                clearedInputTokens: $clearedInputTokens,
                clearedToolUses: $clearedToolUses ?? throw new \ArgumentCountError('$clearedToolUses is required'),
            ),
            Type::CLEAR_THINKING_20251015, 'clear_thinking_20251015' => BetaClearThinking20251015EditResponse::with(
                clearedInputTokens: $clearedInputTokens,
                clearedThinkingTurns: $clearedThinkingTurns ?? throw new \ArgumentCountError('$clearedThinkingTurns is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
