<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\RawContentBlockDelta\Type;

/**
 * @phpstan-import-type TextDeltaShape from \Anthropic\Messages\TextDelta
 * @phpstan-import-type InputJSONDeltaShape from \Anthropic\Messages\InputJSONDelta
 * @phpstan-import-type CitationsDeltaShape from \Anthropic\Messages\CitationsDelta
 * @phpstan-import-type ThinkingDeltaShape from \Anthropic\Messages\ThinkingDelta
 * @phpstan-import-type SignatureDeltaShape from \Anthropic\Messages\SignatureDelta
 * @phpstan-import-type CitationShape from \Anthropic\Messages\CitationsDelta\Citation
 *
 * @phpstan-type RawContentBlockDeltaVariants = TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta
 * @phpstan-type RawContentBlockDeltaShape = RawContentBlockDeltaVariants|TextDeltaShape|InputJSONDeltaShape|CitationsDeltaShape|ThinkingDeltaShape|SignatureDeltaShape
 */
final class RawContentBlockDelta implements ConverterSource
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
            'text_delta' => TextDelta::class,
            'input_json_delta' => InputJSONDelta::class,
            'citations_delta' => CitationsDelta::class,
            'thinking_delta' => ThinkingDelta::class,
            'signature_delta' => SignatureDelta::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CitationShape|null $citation
     *
     * @return ($type is Type::TEXT_DELTA|'text_delta' ? TextDelta : ($type is Type::INPUT_JSON_DELTA|'input_json_delta' ? InputJSONDelta : ($type is Type::CITATIONS_DELTA|'citations_delta' ? CitationsDelta : ($type is Type::THINKING_DELTA|'thinking_delta' ? ThinkingDelta : ($type is Type::SIGNATURE_DELTA|'signature_delta' ? SignatureDelta : TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta)))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        ?string $partialJSON = null,
        CitationCharLocation|array|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation|null $citation = null,
        ?string $thinking = null,
        ?string $signature = null,
    ): TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta {
        return match ($type) {
            Type::TEXT_DELTA, 'text_delta' => TextDelta::with(
                text: $text ?? throw new \ArgumentCountError('$text is required')
            ),
            Type::INPUT_JSON_DELTA, 'input_json_delta' => InputJSONDelta::with(
                partialJSON: $partialJSON ?? throw new \ArgumentCountError('$partialJSON is required'),
            ),
            Type::CITATIONS_DELTA, 'citations_delta' => CitationsDelta::with(
                citation: $citation ?? throw new \ArgumentCountError('$citation is required'),
            ),
            Type::THINKING_DELTA, 'thinking_delta' => ThinkingDelta::with(
                thinking: $thinking ?? throw new \ArgumentCountError('$thinking is required'),
            ),
            Type::SIGNATURE_DELTA, 'signature_delta' => SignatureDelta::with(
                signature: $signature ?? throw new \ArgumentCountError('$signature is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
