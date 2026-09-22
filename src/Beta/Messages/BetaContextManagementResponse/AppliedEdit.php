<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContextManagementResponse;

use Anthropic\Beta\Messages\BetaClearThinking20251015EditResponse;
use Anthropic\Beta\Messages\BetaClearToolUses20250919EditResponse;
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
}
