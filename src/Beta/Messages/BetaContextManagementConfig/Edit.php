<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContextManagementConfig;

use Anthropic\Beta\Messages\BetaClearThinking20251015Edit;
use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaClearToolUses20250919EditShape from \Anthropic\Beta\Messages\BetaClearToolUses20250919Edit
 * @phpstan-import-type BetaClearThinking20251015EditShape from \Anthropic\Beta\Messages\BetaClearThinking20251015Edit
 *
 * @phpstan-type EditShape = BetaClearToolUses20250919EditShape|BetaClearThinking20251015EditShape
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
        ];
    }
}
