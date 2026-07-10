<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * An input memory store the dream reads from. The dream never mutates this store.
 *
 * @phpstan-import-type BetaDreamMemoryStoreInputShape from \Anthropic\Beta\Dreams\BetaDreamMemoryStoreInput
 * @phpstan-import-type BetaDreamSessionsInputShape from \Anthropic\Beta\Dreams\BetaDreamSessionsInput
 *
 * @phpstan-type BetaDreamInputVariants = BetaDreamMemoryStoreInput|BetaDreamSessionsInput
 * @phpstan-type BetaDreamInputShape = BetaDreamInputVariants|BetaDreamMemoryStoreInputShape|BetaDreamSessionsInputShape
 */
final class BetaDreamInput implements ConverterSource
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
            'memory_store' => BetaDreamMemoryStoreInput::class,
            'sessions' => BetaDreamSessionsInput::class,
        ];
    }
}
