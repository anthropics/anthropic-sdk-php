<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class RawMessageStreamEvent implements StaticConverter
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
            'message_start' => RawMessageStartEvent::class,
            'message_delta' => RawMessageDeltaEvent::class,
            'message_stop' => RawMessageStopEvent::class,
            'content_block_start' => RawContentBlockStartEvent::class,
            'content_block_delta' => RawContentBlockDeltaEvent::class,
            'content_block_stop' => RawContentBlockStopEvent::class,
        ];
    }
}
