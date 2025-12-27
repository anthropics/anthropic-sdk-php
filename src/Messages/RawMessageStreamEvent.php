<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type RawMessageStartEventShape from \Anthropic\Messages\RawMessageStartEvent
 * @phpstan-import-type RawMessageDeltaEventShape from \Anthropic\Messages\RawMessageDeltaEvent
 * @phpstan-import-type RawMessageStopEventShape from \Anthropic\Messages\RawMessageStopEvent
 * @phpstan-import-type RawContentBlockStartEventShape from \Anthropic\Messages\RawContentBlockStartEvent
 * @phpstan-import-type RawContentBlockDeltaEventShape from \Anthropic\Messages\RawContentBlockDeltaEvent
 * @phpstan-import-type RawContentBlockStopEventShape from \Anthropic\Messages\RawContentBlockStopEvent
 *
 * @phpstan-type RawMessageStreamEventShape = RawMessageStartEventShape|RawMessageDeltaEventShape|RawMessageStopEventShape|RawContentBlockStartEventShape|RawContentBlockDeltaEventShape|RawContentBlockStopEventShape
 */
final class RawMessageStreamEvent implements ConverterSource
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
            'message_start' => RawMessageStartEvent::class,
            'message_delta' => RawMessageDeltaEvent::class,
            'message_stop' => RawMessageStopEvent::class,
            'content_block_start' => RawContentBlockStartEvent::class,
            'content_block_delta' => RawContentBlockDeltaEvent::class,
            'content_block_stop' => RawContentBlockStopEvent::class,
        ];
    }
}
