<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsMemoryShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemory
 * @phpstan-import-type ManagedAgentsMemoryPrefixShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPrefix
 *
 * @phpstan-type ManagedAgentsMemoryListItemVariants = ManagedAgentsMemory|ManagedAgentsMemoryPrefix
 * @phpstan-type ManagedAgentsMemoryListItemShape = ManagedAgentsMemoryListItemVariants|ManagedAgentsMemoryShape|ManagedAgentsMemoryPrefixShape
 */
final class ManagedAgentsMemoryListItem implements ConverterSource
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
            'memory' => ManagedAgentsMemory::class,
            'memory_prefix' => ManagedAgentsMemoryPrefix::class,
        ];
    }
}
