<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContentBlockSourceContent\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaImageBlockParamShape from \Anthropic\Beta\Messages\BetaImageBlockParam
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaTextCitationParamShape from \Anthropic\Beta\Messages\BetaTextCitationParam
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Messages\BetaImageBlockParam\Source
 * @phpstan-import-type BetaImageTransformationsParamShape from \Anthropic\Beta\Messages\BetaImageTransformationsParam
 *
 * @phpstan-type BetaContentBlockSourceContentVariants = BetaTextBlockParam|BetaImageBlockParam
 * @phpstan-type BetaContentBlockSourceContentShape = BetaContentBlockSourceContentVariants|BetaTextBlockParamShape|BetaImageBlockParamShape
 */
final class BetaContentBlockSourceContent implements ConverterSource
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
            'text' => BetaTextBlockParam::class, 'image' => BetaImageBlockParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param list<BetaTextCitationParamShape>|null $citations
     * @param SourceShape|null $source
     * @param BetaImageTransformationsParam|BetaImageTransformationsParamShape|null $transformations
     *
     * @return ($type is Type::TEXT|'text' ? BetaTextBlockParam : ($type is Type::IMAGE|'image' ? BetaImageBlockParam : BetaTextBlockParam|BetaImageBlockParam))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?array $citations = null,
        BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource|null $source = null,
        BetaImageTransformationsParam|array|null $transformations = null,
    ): BetaTextBlockParam|BetaImageBlockParam {
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
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
