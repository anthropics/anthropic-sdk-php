<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration for enabling Claude's extended thinking.
 *
 * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
 *
 * See [extended thinking](https://docs.claude.com/en/docs/build-with-claude/extended-thinking) for details.
 *
 * @phpstan-import-type BetaThinkingConfigEnabledShape from \Anthropic\Beta\Messages\BetaThinkingConfigEnabled
 * @phpstan-import-type BetaThinkingConfigDisabledShape from \Anthropic\Beta\Messages\BetaThinkingConfigDisabled
 * @phpstan-import-type BetaThinkingConfigAdaptiveShape from \Anthropic\Beta\Messages\BetaThinkingConfigAdaptive
 *
 * @phpstan-type BetaThinkingConfigParamVariants = BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive
 * @phpstan-type BetaThinkingConfigParamShape = BetaThinkingConfigParamVariants|BetaThinkingConfigEnabledShape|BetaThinkingConfigDisabledShape|BetaThinkingConfigAdaptiveShape
 */
final class BetaThinkingConfigParam implements ConverterSource
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
