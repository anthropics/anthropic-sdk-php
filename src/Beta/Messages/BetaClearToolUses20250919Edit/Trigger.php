<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaClearToolUses20250919Edit;

use Anthropic\Beta\Messages\BetaClearToolUses20250919Edit\Trigger\Type;
use Anthropic\Beta\Messages\BetaInputTokensTrigger;
use Anthropic\Beta\Messages\BetaToolUsesTrigger;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Condition that triggers the context management strategy.
 *
 * @phpstan-import-type BetaInputTokensTriggerShape from \Anthropic\Beta\Messages\BetaInputTokensTrigger
 * @phpstan-import-type BetaToolUsesTriggerShape from \Anthropic\Beta\Messages\BetaToolUsesTrigger
 *
 * @phpstan-type TriggerVariants = BetaInputTokensTrigger|BetaToolUsesTrigger
 * @phpstan-type TriggerShape = TriggerVariants|BetaInputTokensTriggerShape|BetaToolUsesTriggerShape
 */
final class Trigger implements ConverterSource
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
            'input_tokens' => BetaInputTokensTrigger::class,
            'tool_uses' => BetaToolUsesTrigger::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::INPUT_TOKENS|'input_tokens' ? BetaInputTokensTrigger : ($type is Type::TOOL_USES|'tool_uses' ? BetaToolUsesTrigger : BetaInputTokensTrigger|BetaToolUsesTrigger))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        int $value
    ): BetaInputTokensTrigger|BetaToolUsesTrigger {
        return match ($type) {
            Type::INPUT_TOKENS, 'input_tokens' => BetaInputTokensTrigger::with(
                value: $value
            ),
            Type::TOOL_USES, 'tool_uses' => BetaToolUsesTrigger::with(
                value: $value
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
