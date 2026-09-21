<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent\Content\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64DocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64ImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsPlainTextDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultCitations;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultContent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock;
use Anthropic\Beta\Sessions\Events\ManagedAgentsURLDocumentSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsURLImageSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Content block in a tool result. Can be `text`, `image`, `document`, or `search_result`.
 *
 * @phpstan-import-type ManagedAgentsTextBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsTextBlock
 * @phpstan-import-type ManagedAgentsImageBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock
 * @phpstan-import-type ManagedAgentsDocumentBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock
 * @phpstan-import-type ManagedAgentsSearchResultBlockShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultBlock
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Source as SourceShape1
 * @phpstan-import-type ManagedAgentsSearchResultCitationsShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultCitations
 * @phpstan-import-type ManagedAgentsSearchResultContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSearchResultContent
 *
 * @phpstan-type ContentVariants = ManagedAgentsTextBlock|ManagedAgentsImageBlock|ManagedAgentsDocumentBlock|ManagedAgentsSearchResultBlock
 * @phpstan-type ContentShape = ContentVariants|ManagedAgentsTextBlockShape|ManagedAgentsImageBlockShape|ManagedAgentsDocumentBlockShape|ManagedAgentsSearchResultBlockShape
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
            'search_result' => ManagedAgentsSearchResultBlock::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::IMAGE|'image' ? SourceShape|null : ($type is Type::DOCUMENT|'document' ? SourceShape1|null : string|null)) $source
     * @param ManagedAgentsSearchResultCitations|ManagedAgentsSearchResultCitationsShape|null $citations
     * @param list<ManagedAgentsSearchResultContent|ManagedAgentsSearchResultContentShape>|null $content
     *
     * @return ($type is Type::TEXT|'text' ? ManagedAgentsTextBlock : ($type is Type::IMAGE|'image' ? ManagedAgentsImageBlock : ($type is Type::DOCUMENT|'document' ? ManagedAgentsDocumentBlock : ($type is Type::SEARCH_RESULT|'search_result' ? ManagedAgentsSearchResultBlock : ManagedAgentsTextBlock|ManagedAgentsImageBlock|ManagedAgentsDocumentBlock|ManagedAgentsSearchResultBlock))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        string|ManagedAgentsBase64ImageSource|array|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource|ManagedAgentsBase64DocumentSource|ManagedAgentsPlainTextDocumentSource|ManagedAgentsURLDocumentSource|ManagedAgentsFileDocumentSource|null $source = null,
        ?string $context = null,
        ?string $title = null,
        ManagedAgentsSearchResultCitations|array|null $citations = null,
        ?array $content = null,
    ): ManagedAgentsTextBlock|ManagedAgentsImageBlock|ManagedAgentsDocumentBlock|ManagedAgentsSearchResultBlock {
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
            Type::SEARCH_RESULT, 'search_result' => ManagedAgentsSearchResultBlock::with(
                type: 'search_result',
                citations: $citations ?? throw new \ArgumentCountError('$citations is required'),
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                title: $title ?? throw new \ArgumentCountError('$title is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
