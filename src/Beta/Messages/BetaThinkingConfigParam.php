<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaThinkingConfigEnabled\Display;
use Anthropic\Beta\Messages\BetaThinkingConfigParam\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration for enabling Claude's extended thinking.
 *
 * When enabled, responses include `thinking` content blocks showing Claude's thinking process before the final answer. Requires a minimum budget of 1,024 tokens and counts towards your `max_tokens` limit.
 *
 * See [extended thinking](https://platform.claude.com/docs/en/build-with-claude/extended-thinking) for details.
 *
 * @phpstan-import-type BetaThinkingConfigEnabledShape from \Anthropic\Beta\Messages\BetaThinkingConfigEnabled
 * @phpstan-import-type BetaThinkingConfigDisabledShape from \Anthropic\Beta\Messages\BetaThinkingConfigDisabled
 * @phpstan-import-type BetaThinkingConfigAdaptiveShape from \Anthropic\Beta\Messages\BetaThinkingConfigAdaptive
 * @phpstan-import-type BetaThinkingBlockBindingShape from \Anthropic\Beta\Messages\BetaThinkingBlockBinding
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaThinkingBlockBinding|BetaThinkingBlockBindingShape|null $blockBinding
     * @param ($type is Type::ENABLED|'enabled' ? Display|value-of<Display>|null : BetaThinkingConfigAdaptive\Display|value-of<BetaThinkingConfigAdaptive\Display>|null) $display
     *
     * @return ($type is Type::ENABLED|'enabled' ? BetaThinkingConfigEnabled : ($type is Type::DISABLED|'disabled' ? BetaThinkingConfigDisabled : ($type is Type::ADAPTIVE|'adaptive' ? BetaThinkingConfigAdaptive : BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?int $budgetTokens = null,
        BetaThinkingBlockBinding|array|null $blockBinding = null,
        Display|BetaThinkingConfigAdaptive\Display|string|null $display = null,
    ): BetaThinkingConfigEnabled|BetaThinkingConfigDisabled|BetaThinkingConfigAdaptive {
        return match ($type) {
            Type::ENABLED, 'enabled' => BetaThinkingConfigEnabled::with(
                budgetTokens: $budgetTokens ?? throw new \ArgumentCountError('$budgetTokens is required'),
                blockBinding: $blockBinding,
                display: $display,
            ),
            Type::DISABLED, 'disabled' => BetaThinkingConfigDisabled::with(),
            Type::ADAPTIVE, 'adaptive' => BetaThinkingConfigAdaptive::with(
                blockBinding: $blockBinding,
                // @phpstan-ignore argument.type
                display: $display,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
