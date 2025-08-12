<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration for enabling Claude's extended thinking.
 *
 * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
 *
 * See [extended thinking](https://docs.anthropic.com/en/docs/build-with-claude/extended-thinking) for details.
 *
 * @phpstan-type thinking_config_param_alias = ThinkingConfigEnabled|ThinkingConfigDisabled
 */
final class ThinkingConfigParam implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return [
            'enabled' => ThinkingConfigEnabled::class,
            'disabled' => ThinkingConfigDisabled::class,
        ];
    }
}
