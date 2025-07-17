<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaRawContentBlockDelta implements StaticConverter
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
            'text_delta' => BetaTextDelta::class,
            'input_json_delta' => BetaInputJSONDelta::class,
            'citations_delta' => BetaCitationsDelta::class,
            'thinking_delta' => BetaThinkingDelta::class,
            'signature_delta' => BetaSignatureDelta::class,
        ];
    }
}
