<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64DocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64ImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRedactedBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsURLDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsURLImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent\Content\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Content block in a user message. Can be `text`, `image`, or `document`.
 *
 * @phpstan-import-type ManagedAgentsTextBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock
 * @phpstan-import-type ManagedAgentsImageBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock
 * @phpstan-import-type ManagedAgentsDocumentBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock
 * @phpstan-import-type ManagedAgentsRedactedBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRedactedBlock
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Source as SourceShape1
 *
 * @phpstan-type ContentVariants = ManagedAgentsTextBlock|ManagedAgentsImageBlock|ManagedAgentsDocumentBlock|ManagedAgentsRedactedBlock
 * @phpstan-type ContentShape = ContentVariants|ManagedAgentsTextBlockShape|ManagedAgentsImageBlockShape|ManagedAgentsDocumentBlockShape|ManagedAgentsRedactedBlockShape
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
            'image' => ManagedAgentsImageBlock::class,
            'document' => ManagedAgentsDocumentBlock::class,
            'redacted' => ManagedAgentsRedactedBlock::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::IMAGE|'image' ? SourceShape|null : SourceShape1|null) $source
     *
     * @return ($type is Type::TEXT|'text' ? ManagedAgentsTextBlock : ($type is Type::IMAGE|'image' ? ManagedAgentsImageBlock : ($type is Type::DOCUMENT|'document' ? ManagedAgentsDocumentBlock : ($type is Type::REDACTED|'redacted' ? ManagedAgentsRedactedBlock : ManagedAgentsTextBlock|ManagedAgentsImageBlock|ManagedAgentsDocumentBlock|ManagedAgentsRedactedBlock))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        ManagedAgentsBase64ImageSource|array|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource|ManagedAgentsBase64DocumentSource|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource|null $source = null,
        ?string $context = null,
        ?string $title = null,
    ): ManagedAgentsTextBlock|ManagedAgentsImageBlock|ManagedAgentsDocumentBlock|ManagedAgentsRedactedBlock {
        return match ($type) {
            Type::TEXT, 'text' => ManagedAgentsTextBlock::with(
                type: 'text',
                text: $text ?? throw new \ArgumentCountError('$text is required'),
            ),
            Type::IMAGE, 'image' => ManagedAgentsImageBlock::with(
                type: 'image',
                source: $source ?? throw new \ArgumentCountError('$source is required'),
            ),
            Type::DOCUMENT, 'document' => ManagedAgentsDocumentBlock::with(
                type: 'document',
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                context: $context,
                title: $title,
            ),
            Type::REDACTED, 'redacted' => ManagedAgentsRedactedBlock::with(
                type: 'redacted'
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
