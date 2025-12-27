<?php

declare(strict_types=1);

namespace Anthropic\Messages;

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
 * @phpstan-import-type ThinkingConfigEnabledShape from \Anthropic\Messages\ThinkingConfigEnabled
 * @phpstan-import-type ThinkingConfigDisabledShape from \Anthropic\Messages\ThinkingConfigDisabled
 *
 * @phpstan-type ThinkingConfigParamShape = ThinkingConfigEnabledShape|ThinkingConfigDisabledShape
 */
final class ThinkingConfigParam implements ConverterSource
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
            'enabled' => ThinkingConfigEnabled::class,
            'disabled' => ThinkingConfigDisabled::class,
        ];
    }
}
