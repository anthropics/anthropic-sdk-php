<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolResultBlockParam\Content;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64ImageSource;
use Anthropic\Messages\Base64PDFSource;
use Anthropic\Messages\BrowserStateBlockParam;
use Anthropic\Messages\BrowserStateTabEntry;
use Anthropic\Messages\CacheControlEphemeral;
use Anthropic\Messages\CitationsConfigParam;
use Anthropic\Messages\ContentBlockSource;
use Anthropic\Messages\DocumentBlockParam;
use Anthropic\Messages\FileDocumentSource;
use Anthropic\Messages\FileImageSource;
use Anthropic\Messages\ImageBlockParam;
use Anthropic\Messages\ImageTransformationsParam;
use Anthropic\Messages\PlainTextSource;
use Anthropic\Messages\SearchResultBlockParam;
use Anthropic\Messages\TextBlockParam;
use Anthropic\Messages\ToolReferenceBlockParam;
use Anthropic\Messages\ToolResultBlockParam\Content\Content\Type;
use Anthropic\Messages\URLImageSource;
use Anthropic\Messages\URLPDFSource;

/**
 * @phpstan-import-type ImageBlockParamShape from \Anthropic\Messages\ImageBlockParam
 * @phpstan-import-type SearchResultBlockParamShape from \Anthropic\Messages\SearchResultBlockParam
 * @phpstan-import-type DocumentBlockParamShape from \Anthropic\Messages\DocumentBlockParam
 * @phpstan-import-type ToolReferenceBlockParamShape from \Anthropic\Messages\ToolReferenceBlockParam
 * @phpstan-import-type BrowserStateBlockParamShape from \Anthropic\Messages\BrowserStateBlockParam
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type TextCitationParamShape from \Anthropic\Messages\TextCitationParam
 * @phpstan-import-type CitationsConfigParamShape from \Anthropic\Messages\CitationsConfigParam
 * @phpstan-import-type SourceShape from \Anthropic\Messages\ImageBlockParam\Source
 * @phpstan-import-type SourceShape from \Anthropic\Messages\DocumentBlockParam\Source as SourceShape1
 * @phpstan-import-type ImageTransformationsParamShape from \Anthropic\Messages\ImageTransformationsParam
 * @phpstan-import-type BrowserStateTabEntryShape from \Anthropic\Messages\BrowserStateTabEntry
 * @phpstan-import-type BrowserStateChangeShape from \Anthropic\Messages\BrowserStateChange
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 *
 * @phpstan-type ContentVariants = TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam|ToolReferenceBlockParam|BrowserStateBlockParam
 * @phpstan-type ContentShape = ContentVariants|TextBlockParamShape|ImageBlockParamShape|SearchResultBlockParamShape|DocumentBlockParamShape|ToolReferenceBlockParamShape|BrowserStateBlockParamShape
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
            'text' => TextBlockParam::class,
            'image' => ImageBlockParam::class,
            'search_result' => SearchResultBlockParam::class,
            'document' => DocumentBlockParam::class,
            'tool_reference' => ToolReferenceBlockParam::class,
            'browser_state' => BrowserStateBlockParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param ($type is Type::TEXT|'text' ? list<TextCitationParamShape>|null : CitationsConfigParam|CitationsConfigParamShape|null) $citations
     * @param ($type is Type::IMAGE|'image' ? SourceShape|null : ($type is Type::SEARCH_RESULT|'search_result' ? string|null : SourceShape1|null)) $source
     * @param ImageTransformationsParam|ImageTransformationsParamShape|null $transformations
     * @param list<TextBlockParam|TextBlockParamShape>|null $content
     * @param list<BrowserStateTabEntry|BrowserStateTabEntryShape>|null $tabs
     * @param list<BrowserStateChangeShape>|null $stateChanges
     *
     * @return ($type is Type::TEXT|'text' ? TextBlockParam : ($type is Type::IMAGE|'image' ? ImageBlockParam : ($type is Type::SEARCH_RESULT|'search_result' ? SearchResultBlockParam : ($type is Type::DOCUMENT|'document' ? DocumentBlockParam : ($type is Type::TOOL_REFERENCE|'tool_reference' ? ToolReferenceBlockParam : ($type is Type::BROWSER_STATE|'browser_state' ? BrowserStateBlockParam : TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam|ToolReferenceBlockParam|BrowserStateBlockParam))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        CacheControlEphemeral|array|null $cacheControl = null,
        array|CitationsConfigParam|null $citations = null,
        string|Base64ImageSource|array|URLImageSource|FileImageSource|Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource|FileDocumentSource|null $source = null,
        ImageTransformationsParam|array|null $transformations = null,
        ?array $content = null,
        ?string $title = null,
        ?string $context = null,
        ?string $toolName = null,
        ?array $tabs = null,
        ?array $stateChanges = null,
    ): TextBlockParam|ImageBlockParam|SearchResultBlockParam|DocumentBlockParam|ToolReferenceBlockParam|BrowserStateBlockParam {
        return match ($type) {
            Type::TEXT, 'text' => TextBlockParam::with(
                text: $text ?? throw new \ArgumentCountError('$text is required'),
                cacheControl: $cacheControl,
                citations: $citations,
            ),
            Type::IMAGE, 'image' => ImageBlockParam::with(
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                transformations: $transformations,
            ),
            Type::SEARCH_RESULT, 'search_result' => SearchResultBlockParam::with(
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                title: $title ?? throw new \ArgumentCountError('$title is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
            ),
            Type::DOCUMENT, 'document' => DocumentBlockParam::with(
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
                context: $context,
                title: $title,
            ),
            Type::TOOL_REFERENCE, 'tool_reference' => ToolReferenceBlockParam::with(
                toolName: $toolName ?? throw new \ArgumentCountError('$toolName is required'),
                cacheControl: $cacheControl,
            ),
            Type::BROWSER_STATE, 'browser_state' => BrowserStateBlockParam::with(
                tabs: $tabs ?? throw new \ArgumentCountError('$tabs is required'),
                cacheControl: $cacheControl,
                stateChanges: $stateChanges,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
