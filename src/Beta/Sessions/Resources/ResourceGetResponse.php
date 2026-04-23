<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The requested session resource.
 *
 * @phpstan-import-type ManagedAgentsGitHubRepositoryResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource
 * @phpstan-import-type ManagedAgentsFileResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource
 * @phpstan-import-type ManagedAgentsMemoryStoreResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource
 *
 * @phpstan-type ResourceGetResponseVariants = ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource
 * @phpstan-type ResourceGetResponseShape = ResourceGetResponseVariants|ManagedAgentsGitHubRepositoryResourceShape|ManagedAgentsFileResourceShape|ManagedAgentsMemoryStoreResourceShape
 */
final class ResourceGetResponse implements ConverterSource
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
