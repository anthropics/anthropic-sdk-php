<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class BetaRawMessageStreamEvent implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
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
