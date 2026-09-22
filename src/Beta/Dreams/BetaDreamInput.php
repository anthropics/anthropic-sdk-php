<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\Dreams\BetaDreamInput\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A source that a dream reads, such as a memory store or a set of sessions.
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<string>|null $sessionIDs
     *
     * @return ($type is Type::MEMORY_STORE|'memory_store' ? BetaDreamMemoryStoreInput : ($type is Type::SESSIONS|'sessions' ? BetaDreamSessionsInput : BetaDreamMemoryStoreInput|BetaDreamSessionsInput))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $memoryStoreID = null,
        ?array $sessionIDs = null
    ): BetaDreamMemoryStoreInput|BetaDreamSessionsInput {
        return match ($type) {
            Type::MEMORY_STORE, 'memory_store' => BetaDreamMemoryStoreInput::with(
                type: 'memory_store',
                memoryStoreID: $memoryStoreID ?? throw new \ArgumentCountError('$memoryStoreID is required'),
            ),
            Type::SESSIONS, 'sessions' => BetaDreamSessionsInput::with(
                type: 'sessions',
                sessionIDs: $sessionIDs ?? throw new \ArgumentCountError('$sessionIDs is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
