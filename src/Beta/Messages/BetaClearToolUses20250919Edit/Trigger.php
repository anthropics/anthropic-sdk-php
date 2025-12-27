<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaClearToolUses20250919Edit;

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
 * @phpstan-type TriggerShape = BetaInputTokensTriggerShape|BetaToolUsesTriggerShape
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
}
