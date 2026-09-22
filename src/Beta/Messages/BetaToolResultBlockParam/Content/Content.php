<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolResultBlockParam\Content;

use Anthropic\Beta\Messages\BetaBase64ImageSource;
use Anthropic\Beta\Messages\BetaBase64PDFSource;
use Anthropic\Beta\Messages\BetaBrowserStateBlockParam;
use Anthropic\Beta\Messages\BetaBrowserStateTabEntry;
use Anthropic\Beta\Messages\BetaCacheControlEphemeral;
use Anthropic\Beta\Messages\BetaCitationsConfigParam;
use Anthropic\Beta\Messages\BetaContentBlockSource;
use Anthropic\Beta\Messages\BetaFileDocumentSource;
use Anthropic\Beta\Messages\BetaFileImageSource;
use Anthropic\Beta\Messages\BetaImageBlockParam;
use Anthropic\Beta\Messages\BetaImageTransformationsParam;
use Anthropic\Beta\Messages\BetaPlainTextSource;
use Anthropic\Beta\Messages\BetaRequestDocumentBlock;
use Anthropic\Beta\Messages\BetaSearchResultBlockParam;
use Anthropic\Beta\Messages\BetaTextBlockParam;
use Anthropic\Beta\Messages\BetaToolReferenceBlockParam;
use Anthropic\Beta\Messages\BetaToolResultBlockParam\Content\Content\Type;
use Anthropic\Beta\Messages\BetaURLImageSource;
use Anthropic\Beta\Messages\BetaURLPDFSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaImageBlockParamShape from \Anthropic\Beta\Messages\BetaImageBlockParam
 * @phpstan-import-type BetaSearchResultBlockParamShape from \Anthropic\Beta\Messages\BetaSearchResultBlockParam
 * @phpstan-import-type BetaRequestDocumentBlockShape from \Anthropic\Beta\Messages\BetaRequestDocumentBlock
 * @phpstan-import-type BetaToolReferenceBlockParamShape from \Anthropic\Beta\Messages\BetaToolReferenceBlockParam
 * @phpstan-import-type BetaBrowserStateBlockParamShape from \Anthropic\Beta\Messages\BetaBrowserStateBlockParam
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaTextCitationParamShape from \Anthropic\Beta\Messages\BetaTextCitationParam
 * @phpstan-import-type BetaCitationsConfigParamShape from \Anthropic\Beta\Messages\BetaCitationsConfigParam
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Messages\BetaImageBlockParam\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source as SourceShape1
 * @phpstan-import-type BetaImageTransformationsParamShape from \Anthropic\Beta\Messages\BetaImageTransformationsParam
 * @phpstan-import-type BetaBrowserStateTabEntryShape from \Anthropic\Beta\Messages\BetaBrowserStateTabEntry
 * @phpstan-import-type BetaBrowserStateChangeShape from \Anthropic\Beta\Messages\BetaBrowserStateChange
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 *
 * @phpstan-type ContentVariants = BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam|BetaBrowserStateBlockParam
 * @phpstan-type ContentShape = ContentVariants|BetaTextBlockParamShape|BetaImageBlockParamShape|BetaSearchResultBlockParamShape|BetaRequestDocumentBlockShape|BetaToolReferenceBlockParamShape|BetaBrowserStateBlockParamShape
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
            'text' => BetaTextBlockParam::class,
            'image' => BetaImageBlockParam::class,
            'search_result' => BetaSearchResultBlockParam::class,
            'document' => BetaRequestDocumentBlock::class,
            'tool_reference' => BetaToolReferenceBlockParam::class,
            'browser_state' => BetaBrowserStateBlockParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param ($type is Type::TEXT|'text' ? list<BetaTextCitationParamShape>|null : BetaCitationsConfigParam|BetaCitationsConfigParamShape|null) $citations
     * @param ($type is Type::IMAGE|'image' ? SourceShape|null : ($type is Type::SEARCH_RESULT|'search_result' ? string|null : SourceShape1|null)) $source
     * @param BetaImageTransformationsParam|BetaImageTransformationsParamShape|null $transformations
     * @param list<BetaTextBlockParam|BetaTextBlockParamShape>|null $content
     * @param list<BetaBrowserStateTabEntry|BetaBrowserStateTabEntryShape>|null $tabs
     * @param list<BetaBrowserStateChangeShape>|null $stateChanges
     *
     * @return ($type is Type::TEXT|'text' ? BetaTextBlockParam : ($type is Type::IMAGE|'image' ? BetaImageBlockParam : ($type is Type::SEARCH_RESULT|'search_result' ? BetaSearchResultBlockParam : ($type is Type::DOCUMENT|'document' ? BetaRequestDocumentBlock : ($type is Type::TOOL_REFERENCE|'tool_reference' ? BetaToolReferenceBlockParam : ($type is Type::BROWSER_STATE|'browser_state' ? BetaBrowserStateBlockParam : BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam|BetaBrowserStateBlockParam))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        array|BetaCitationsConfigParam|null $citations = null,
        string|BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource|BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource|null $source = null,
        BetaImageTransformationsParam|array|null $transformations = null,
        ?array $content = null,
        ?string $title = null,
        ?string $context = null,
        ?string $toolName = null,
        ?array $tabs = null,
        ?array $stateChanges = null,
    ): BetaTextBlockParam|BetaImageBlockParam|BetaSearchResultBlockParam|BetaRequestDocumentBlock|BetaToolReferenceBlockParam|BetaBrowserStateBlockParam {
        return match ($type) {
            Type::TEXT, 'text' => BetaTextBlockParam::with(
                text: $text ?? throw new \ArgumentCountError('$text is required'),
                cacheControl: $cacheControl,
                citations: $citations,
            ),
            Type::IMAGE, 'image' => BetaImageBlockParam::with(
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                transformations: $transformations,
            ),
            Type::SEARCH_RESULT, 'search_result' => BetaSearchResultBlockParam::with(
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                title: $title ?? throw new \ArgumentCountError('$title is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
            ),
            Type::DOCUMENT, 'document' => BetaRequestDocumentBlock::with(
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
                context: $context,
                title: $title,
            ),
            Type::TOOL_REFERENCE, 'tool_reference' => BetaToolReferenceBlockParam::with(
                toolName: $toolName ?? throw new \ArgumentCountError('$toolName is required'),
                cacheControl: $cacheControl,
            ),
            Type::BROWSER_STATE, 'browser_state' => BetaBrowserStateBlockParam::with(
                tabs: $tabs ?? throw new \ArgumentCountError('$tabs is required'),
                cacheControl: $cacheControl,
                stateChanges: $stateChanges,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
