<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaRawMessageStreamEvent implements StaticConverter
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
            'message_start' => BetaRawMessageStartEvent::class,
            'message_delta' => BetaRawMessageDeltaEvent::class,
            'message_stop' => BetaRawMessageStopEvent::class,
            'content_block_start' => BetaRawContentBlockStartEvent::class,
            'content_block_delta' => BetaRawContentBlockDeltaEvent::class,
            'content_block_stop' => BetaRawContentBlockStopEvent::class,
        ];
    }
}
