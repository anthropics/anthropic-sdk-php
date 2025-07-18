<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class BetaRawContentBlockDelta implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
     * >
     */
    public static function variants(): array
    {
        return [
            'text_delta' => BetaTextDelta::class,
            'input_json_delta' => BetaInputJSONDelta::class,
            'citations_delta' => BetaCitationsDelta::class,
            'thinking_delta' => BetaThinkingDelta::class,
            'signature_delta' => BetaSignatureDelta::class,
        ];
    }
}
