<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextDeltaShape from \Anthropic\Beta\Messages\BetaTextDelta
 * @phpstan-import-type BetaInputJSONDeltaShape from \Anthropic\Beta\Messages\BetaInputJSONDelta
 * @phpstan-import-type BetaCitationsDeltaShape from \Anthropic\Beta\Messages\BetaCitationsDelta
 * @phpstan-import-type BetaThinkingDeltaShape from \Anthropic\Beta\Messages\BetaThinkingDelta
 * @phpstan-import-type BetaSignatureDeltaShape from \Anthropic\Beta\Messages\BetaSignatureDelta
 *
 * @phpstan-type BetaRawContentBlockDeltaShape = BetaTextDeltaShape|BetaInputJSONDeltaShape|BetaCitationsDeltaShape|BetaThinkingDeltaShape|BetaSignatureDeltaShape
 */
final class BetaRawContentBlockDelta implements ConverterSource
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
            'text_delta' => BetaTextDelta::class,
            'input_json_delta' => BetaInputJSONDelta::class,
            'citations_delta' => BetaCitationsDelta::class,
            'thinking_delta' => BetaThinkingDelta::class,
            'signature_delta' => BetaSignatureDelta::class,
        ];
    }
}
