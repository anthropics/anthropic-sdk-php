<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type raw_content_block_delta_alias = TextDelta|InputJSONDelta|CitationsDelta|ThinkingDelta|SignatureDelta
 */
final class RawContentBlockDelta implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
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
