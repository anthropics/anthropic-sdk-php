<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ThinkingConfigEnabled\Display;
use Anthropic\Messages\ThinkingConfigParam\Type;

/**
 * Configuration for enabling Claude's extended thinking.
 *
 * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
 *
 * See [extended thinking](https://platform.claude.com/docs/en/build-with-claude/extended-thinking) for details.
 *
 * @phpstan-import-type ThinkingConfigEnabledShape from \Anthropic\Messages\ThinkingConfigEnabled
 * @phpstan-import-type ThinkingConfigDisabledShape from \Anthropic\Messages\ThinkingConfigDisabled
 * @phpstan-import-type ThinkingConfigAdaptiveShape from \Anthropic\Messages\ThinkingConfigAdaptive
 *
 * @phpstan-type ThinkingConfigParamVariants = ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive
 * @phpstan-type ThinkingConfigParamShape = ThinkingConfigParamVariants|ThinkingConfigEnabledShape|ThinkingConfigDisabledShape|ThinkingConfigAdaptiveShape
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
            'adaptive' => ThinkingConfigAdaptive::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::ENABLED|'enabled' ? Display|value-of<Display>|null : ThinkingConfigAdaptive\Display|value-of<ThinkingConfigAdaptive\Display>|null) $display
     *
     * @return ($type is Type::ENABLED|'enabled' ? ThinkingConfigEnabled : ($type is Type::DISABLED|'disabled' ? ThinkingConfigDisabled : ($type is Type::ADAPTIVE|'adaptive' ? ThinkingConfigAdaptive : ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?int $budgetTokens = null,
        Display|ThinkingConfigAdaptive\Display|string|null $display = null,
    ): ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigAdaptive {
        return match ($type) {
            Type::ENABLED, 'enabled' => ThinkingConfigEnabled::with(
                budgetTokens: $budgetTokens ?? throw new \ArgumentCountError('$budgetTokens is required'),
                display: $display,
            ),
            Type::DISABLED, 'disabled' => ThinkingConfigDisabled::with(),
            Type::ADAPTIVE, 'adaptive' => ThinkingConfigAdaptive::with(
                // @phpstan-ignore argument.type
                display: $display,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
