<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class RawContentBlockDelta implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
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
