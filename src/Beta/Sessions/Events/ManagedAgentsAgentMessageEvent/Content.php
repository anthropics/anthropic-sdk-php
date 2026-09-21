<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent\Content\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRedactedBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Content block in an agent message.
 *
 * @phpstan-import-type ManagedAgentsTextBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock
 * @phpstan-import-type ManagedAgentsRedactedBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRedactedBlock
 *
 * @phpstan-type ContentVariants = ManagedAgentsTextBlock|ManagedAgentsRedactedBlock
 * @phpstan-type ContentShape = ContentVariants|ManagedAgentsTextBlockShape|ManagedAgentsRedactedBlockShape
 */
final class Content implements ConverterSource
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
            'text' => ManagedAgentsTextBlock::class,
            'redacted' => ManagedAgentsRedactedBlock::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::TEXT|'text' ? ManagedAgentsTextBlock : ($type is Type::REDACTED|'redacted' ? ManagedAgentsRedactedBlock : ManagedAgentsTextBlock|ManagedAgentsRedactedBlock))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
    ): ManagedAgentsTextBlock|ManagedAgentsRedactedBlock {
        return match ($type) {
            Type::TEXT, 'text' => ManagedAgentsTextBlock::with(
                type: 'text',
                text: $text ?? throw new \ArgumentCountError('$text is required'),
            ),
            Type::REDACTED, 'redacted' => ManagedAgentsRedactedBlock::with(
                type: 'redacted'
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
