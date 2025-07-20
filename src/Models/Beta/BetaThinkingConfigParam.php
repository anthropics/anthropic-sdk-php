<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_thinking_config_param_alias = BetaThinkingConfigEnabled|BetaThinkingConfigDisabled
 */
final class BetaThinkingConfigParam implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
     * >
     */
    public static function variants(): array
    {
        return [
            'enabled' => BetaThinkingConfigEnabled::class,
            'disabled' => BetaThinkingConfigDisabled::class,
        ];
    }
}
