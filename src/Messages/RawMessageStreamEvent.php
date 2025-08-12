<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type raw_message_stream_event_alias = RawMessageStartEvent|RawMessageDeltaEvent|RawMessageStopEvent|RawContentBlockStartEvent|RawContentBlockDeltaEvent|RawContentBlockStopEvent
 */
final class RawMessageStreamEvent implements ConverterSource
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
            'message_start' => RawMessageStartEvent::class,
            'message_delta' => RawMessageDeltaEvent::class,
            'message_stop' => RawMessageStopEvent::class,
            'content_block_start' => RawContentBlockStartEvent::class,
            'content_block_delta' => RawContentBlockDeltaEvent::class,
            'content_block_stop' => RawContentBlockStopEvent::class,
        ];
    }
}
