<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ThinkingConfigEnabled\Display;
use Anthropic\Messages\ThinkingConfigParam\Type;

/**
 * Configuration for Claude's thinking.
 *
 * With `{"type": "adaptive"}`, Claude decides when and how much to think. With `{"type": "enabled"}` (manual extended thinking), you set a `budget_tokens` of at least 1,024. Thinking tokens count toward your `max_tokens` limit.
 *
 * Which `type` values are accepted, and what happens when you omit `thinking`, depend on the model. See [thinking](https://platform.claude.com/docs/en/build-with-claude/thinking#configuring-thinking) for each model's behavior.
 *
 * @phpstan-import-type ThinkingConfigEnabledShape from \Anthropic\Messages\ThinkingConfigEnabled
 * @phpstan-import-type ThinkingConfigDisabledShape from \Anthropic\Messages\ThinkingConfigDisabled
 * @phpstan-import-type ThinkingConfigBetweenToolsShape from \Anthropic\Messages\ThinkingConfigBetweenTools
 * @phpstan-import-type ThinkingConfigAdaptiveShape from \Anthropic\Messages\ThinkingConfigAdaptive
 *
 * @phpstan-type ThinkingConfigParamVariants = ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigBetweenTools|ThinkingConfigAdaptive
 * @phpstan-type ThinkingConfigParamShape = ThinkingConfigParamVariants|ThinkingConfigEnabledShape|ThinkingConfigDisabledShape|ThinkingConfigBetweenToolsShape|ThinkingConfigAdaptiveShape
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
            'between_tools' => ThinkingConfigBetweenTools::class,
            'adaptive' => ThinkingConfigAdaptive::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::ENABLED|'enabled' ? Display|value-of<Display>|null : ThinkingConfigAdaptive\Display|value-of<ThinkingConfigAdaptive\Display>|null) $display
     *
     * @return ($type is Type::ENABLED|'enabled' ? ThinkingConfigEnabled : ($type is Type::DISABLED|'disabled' ? ThinkingConfigDisabled : ($type is Type::BETWEEN_TOOLS|'between_tools' ? ThinkingConfigBetweenTools : ($type is Type::ADAPTIVE|'adaptive' ? ThinkingConfigAdaptive : ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigBetweenTools|ThinkingConfigAdaptive))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?int $budgetTokens = null,
        Display|ThinkingConfigAdaptive\Display|string|null $display = null,
    ): ThinkingConfigEnabled|ThinkingConfigDisabled|ThinkingConfigBetweenTools|ThinkingConfigAdaptive {
        return match ($type) {
            Type::ENABLED, 'enabled' => ThinkingConfigEnabled::with(
                budgetTokens: $budgetTokens ?? throw new \ArgumentCountError('$budgetTokens is required'),
                // @phpstan-ignore argument.type
                display: $display,
            ),
            Type::DISABLED, 'disabled' => ThinkingConfigDisabled::with(),
            Type::BETWEEN_TOOLS, 'between_tools' => ThinkingConfigBetweenTools::with(
            ),
            Type::ADAPTIVE, 'adaptive' => ThinkingConfigAdaptive::with(
                // @phpstan-ignore argument.type
                display: $display,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
