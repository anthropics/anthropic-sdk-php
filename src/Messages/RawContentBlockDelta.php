<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type TextDeltaShape from \Anthropic\Messages\TextDelta
 * @phpstan-import-type InputJSONDeltaShape from \Anthropic\Messages\InputJSONDelta
 * @phpstan-import-type CitationsDeltaShape from \Anthropic\Messages\CitationsDelta
 * @phpstan-import-type ThinkingDeltaShape from \Anthropic\Messages\ThinkingDelta
 * @phpstan-import-type SignatureDeltaShape from \Anthropic\Messages\SignatureDelta
 *
 * @phpstan-type RawContentBlockDeltaShape = TextDeltaShape|InputJSONDeltaShape|CitationsDeltaShape|ThinkingDeltaShape|SignatureDeltaShape
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
}
