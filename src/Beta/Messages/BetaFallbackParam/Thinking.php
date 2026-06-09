<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaFallbackParam;

use Anthropic\Beta\Messages\BetaThinkingConfigAdaptive;
use Anthropic\Beta\Messages\BetaThinkingConfigDisabled;
use Anthropic\Beta\Messages\BetaThinkingConfigEnabled;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaThinkingConfigEnabledShape from \Anthropic\Beta\Messages\BetaThinkingConfigEnabled
 * @phpstan-import-type BetaThinkingConfigDisabledShape from \Anthropic\Beta\Messages\BetaThinkingConfigDisabled
 * @phpstan-import-type BetaThinkingConfigAdaptiveShape from \Anthropic\Beta\Messages\BetaThinkingConfigAdaptive
 *
 * @phpstan-type ThinkingVariants = BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive
 * @phpstan-type ThinkingShape = ThinkingVariants|BetaThinkingConfigEnabledShape|BetaThinkingConfigDisabledShape|BetaThinkingConfigAdaptiveShape
 */
final class Thinking implements ConverterSource
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
            'enabled' => BetaThinkingConfigEnabled::class,
            'disabled' => BetaThinkingConfigDisabled::class,
            'adaptive' => BetaThinkingConfigAdaptive::class,
        ];
    }
}
