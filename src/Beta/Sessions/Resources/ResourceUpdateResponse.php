<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource\Access;
use Anthropic\Beta\Sessions\Resources\ResourceUpdateResponse\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The updated session resource.
 *
 * @phpstan-import-type ManagedAgentsGitHubRepositoryResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource
 * @phpstan-import-type ManagedAgentsFileResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource
 * @phpstan-import-type ManagedAgentsMemoryStoreResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource
 * @phpstan-import-type CheckoutShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource\Checkout
 *
 * @phpstan-type ResourceUpdateResponseVariants = ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource
 * @phpstan-type ResourceUpdateResponseShape = ResourceUpdateResponseVariants|ManagedAgentsGitHubRepositoryResourceShape|ManagedAgentsFileResourceShape|ManagedAgentsMemoryStoreResourceShape
 */
final class ResourceUpdateResponse implements ConverterSource
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
            'github_repository' => ManagedAgentsGitHubRepositoryResource::class,
            'file' => ManagedAgentsFileResource::class,
            'memory_store' => ManagedAgentsMemoryStoreResource::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CheckoutShape|null $checkout
     * @param Access|value-of<Access>|null $access
     *
     * @return ($type is Type::GITHUB_REPOSITORY|'github_repository' ? ManagedAgentsGitHubRepositoryResource : ($type is Type::FILE|'file' ? ManagedAgentsFileResource : ($type is Type::MEMORY_STORE|'memory_store' ? ManagedAgentsMemoryStoreResource : ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $id = null,
        ?\DateTimeInterface $createdAt = null,
        ?string $mountPath = null,
        ?\DateTimeInterface $updatedAt = null,
        ?string $url = null,
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout = null,
        ?string $fileID = null,
        ?string $memoryStoreID = null,
        Access|string|null $access = null,
        ?string $description = null,
        ?string $instructions = null,
        ?string $name = null,
    ): ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource {
        return match ($type) {
            Type::GITHUB_REPOSITORY, 'github_repository' => ManagedAgentsGitHubRepositoryResource::with(
                type: 'github_repository',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                createdAt: $createdAt ?? throw new \ArgumentCountError('$createdAt is required'),
                mountPath: $mountPath ?? throw new \ArgumentCountError('$mountPath is required'),
                updatedAt: $updatedAt ?? throw new \ArgumentCountError('$updatedAt is required'),
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                checkout: $checkout,
            ),
            Type::FILE, 'file' => ManagedAgentsFileResource::with(
                type: 'file',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                createdAt: $createdAt ?? throw new \ArgumentCountError('$createdAt is required'),
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
                mountPath: $mountPath ?? throw new \ArgumentCountError('$mountPath is required'),
                updatedAt: $updatedAt ?? throw new \ArgumentCountError('$updatedAt is required'),
            ),
            Type::MEMORY_STORE, 'memory_store' => ManagedAgentsMemoryStoreResource::with(
                type: 'memory_store',
                memoryStoreID: $memoryStoreID ?? throw new \ArgumentCountError('$memoryStoreID is required'),
                access: $access,
                description: $description,
                instructions: $instructions,
                mountPath: $mountPath,
                name: $name,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
