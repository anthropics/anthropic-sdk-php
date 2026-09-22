<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ContentBlockSourceContent\Type;

/**
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 * @phpstan-import-type ImageBlockParamShape from \Anthropic\Messages\ImageBlockParam
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type TextCitationParamShape from \Anthropic\Messages\TextCitationParam
 * @phpstan-import-type SourceShape from \Anthropic\Messages\ImageBlockParam\Source
 * @phpstan-import-type ImageTransformationsParamShape from \Anthropic\Messages\ImageTransformationsParam
 *
 * @phpstan-type ContentBlockSourceContentVariants = TextBlockParam|ImageBlockParam
 * @phpstan-type ContentBlockSourceContentShape = ContentBlockSourceContentVariants|TextBlockParamShape|ImageBlockParamShape
 */
final class ContentBlockSourceContent implements ConverterSource
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
        return ['text' => TextBlockParam::class, 'image' => ImageBlockParam::class];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param list<TextCitationParamShape>|null $citations
     * @param SourceShape|null $source
     * @param ImageTransformationsParam|ImageTransformationsParamShape|null $transformations
     *
     * @return ($type is Type::TEXT|'text' ? TextBlockParam : ($type is Type::IMAGE|'image' ? ImageBlockParam : TextBlockParam|ImageBlockParam))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        CacheControlEphemeral|array|null $cacheControl = null,
        ?array $citations = null,
        Base64ImageSource|array|URLImageSource|FileImageSource|null $source = null,
        ImageTransformationsParam|array|null $transformations = null,
    ): TextBlockParam|ImageBlockParam {
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
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
