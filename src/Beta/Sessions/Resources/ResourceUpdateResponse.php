<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The updated session resource.
 *
 * @phpstan-import-type ManagedAgentsGitHubRepositoryResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource
 * @phpstan-import-type ManagedAgentsFileResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource
 * @phpstan-import-type ManagedAgentsMemoryStoreResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource
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
}
