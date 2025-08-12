<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_raw_content_block_delta_alias = BetaTextDelta|BetaInputJSONDelta|BetaCitationsDelta|BetaThinkingDelta|BetaSignatureDelta
 */
final class BetaRawContentBlockDelta implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
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
