<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryListItem\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * One item in a [List memories](/en/api/beta/memory_stores/memories/list) response: either a `memory` object or, when `depth` is set, a `memory_prefix` rollup marker.
 *
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::MEMORY|'memory' ? ManagedAgentsMemory : ($type is Type::MEMORY_PREFIX|'memory_prefix' ? ManagedAgentsMemoryPrefix : ManagedAgentsMemory|ManagedAgentsMemoryPrefix))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $path,
        ?string $id = null,
        ?string $contentSha256 = null,
        ?int $contentSizeBytes = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $memoryStoreID = null,
        ?string $memoryVersionID = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $content = null,
    ): ManagedAgentsMemory|ManagedAgentsMemoryPrefix {
        return match ($type) {
            Type::MEMORY, 'memory' => ManagedAgentsMemory::with(
                type: 'memory',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                contentSha256: $contentSha256 ?? throw new \ArgumentCountError('$contentSha256 is required'),
                contentSizeBytes: $contentSizeBytes ?? throw new \ArgumentCountError('$contentSizeBytes is required'),
                createdAt: $createdAt ?? throw new \ArgumentCountError('$createdAt is required'),
                memoryStoreID: $memoryStoreID ?? throw new \ArgumentCountError('$memoryStoreID is required'),
                memoryVersionID: $memoryVersionID ?? throw new \ArgumentCountError('$memoryVersionID is required'),
                path: $path,
                updatedAt: $updatedAt ?? throw new \ArgumentCountError('$updatedAt is required'),
                content: $content,
            ),
            Type::MEMORY_PREFIX, 'memory_prefix' => ManagedAgentsMemoryPrefix::with(
                type: 'memory_prefix',
                path: $path
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
