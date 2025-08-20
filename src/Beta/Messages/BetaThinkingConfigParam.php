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
 * See [extended thinking](https://docs.anthropic.com/en/docs/build-with-claude/extended-thinking) for details.
 *
 * @phpstan-type beta_thinking_config_param_alias = BetaThinkingConfigEnabled|BetaThinkingConfigDisabled
 */
final class BetaThinkingConfigParam implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [
            'enabled' => BetaThinkingConfigEnabled::class,
            'disabled' => BetaThinkingConfigDisabled::class,
        ];
    }
}
