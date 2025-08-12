<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_raw_message_stream_event_alias = BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent
 */
final class BetaRawMessageStreamEvent implements ConverterSource
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
            'message_start' => BetaRawMessageStartEvent::class,
            'message_delta' => BetaRawMessageDeltaEvent::class,
            'message_stop' => BetaRawMessageStopEvent::class,
            'content_block_start' => BetaRawContentBlockStartEvent::class,
            'content_block_delta' => BetaRawContentBlockDeltaEvent::class,
            'content_block_stop' => BetaRawContentBlockStopEvent::class,
        ];
    }
}
