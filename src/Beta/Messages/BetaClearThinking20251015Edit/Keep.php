<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaClearThinking20251015Edit;

use Anthropic\Beta\Messages\BetaAllThinkingTurns;
use Anthropic\Beta\Messages\BetaThinkingTurns;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Number of most recent assistant turns to keep thinking blocks for. Older turns will have their thinking blocks removed.
 */
final class Keep implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [BetaThinkingTurns::class, BetaAllThinkingTurns::class, 'string'];
    }
}
