<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaRawMessageStartEventShape from \Anthropic\Beta\Messages\BetaRawMessageStartEvent
 * @phpstan-import-type BetaRawMessageDeltaEventShape from \Anthropic\Beta\Messages\BetaRawMessageDeltaEvent
 * @phpstan-import-type BetaRawMessageStopEventShape from \Anthropic\Beta\Messages\BetaRawMessageStopEvent
 * @phpstan-import-type BetaRawContentBlockStartEventShape from \Anthropic\Beta\Messages\BetaRawContentBlockStartEvent
 * @phpstan-import-type BetaRawContentBlockDeltaEventShape from \Anthropic\Beta\Messages\BetaRawContentBlockDeltaEvent
 * @phpstan-import-type BetaRawContentBlockStopEventShape from \Anthropic\Beta\Messages\BetaRawContentBlockStopEvent
 *
 * @phpstan-type BetaRawMessageStreamEventVariants = BetaRawMessageStartEvent|BetaRawMessageDeltaEvent|BetaRawMessageStopEvent|BetaRawContentBlockStartEvent|BetaRawContentBlockDeltaEvent|BetaRawContentBlockStopEvent
 * @phpstan-type BetaRawMessageStreamEventShape = BetaRawMessageStreamEventVariants|BetaRawMessageStartEventShape|BetaRawMessageDeltaEventShape|BetaRawMessageStopEventShape|BetaRawContentBlockStartEventShape|BetaRawContentBlockDeltaEventShape|BetaRawContentBlockStopEventShape
 */
final class BetaRawMessageStreamEvent implements ConverterSource
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
            'message_start' => BetaRawMessageStartEvent::class,
            'message_delta' => BetaRawMessageDeltaEvent::class,
            'message_stop' => BetaRawMessageStopEvent::class,
            'content_block_start' => BetaRawContentBlockStartEvent::class,
            'content_block_delta' => BetaRawContentBlockDeltaEvent::class,
            'content_block_stop' => BetaRawContentBlockStopEvent::class,
        ];
    }
}
