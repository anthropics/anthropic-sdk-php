<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A memory store attached to an agent session.
 *
 * @phpstan-import-type ManagedAgentsGitHubRepositoryResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource
 * @phpstan-import-type ManagedAgentsFileResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource
 * @phpstan-import-type ManagedAgentsMemoryStoreResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsMemoryStoreResource
 *
 * @phpstan-type ManagedAgentsSessionResourceVariants = ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource|ManagedAgentsMemoryStoreResource
 * @phpstan-type ManagedAgentsSessionResourceShape = ManagedAgentsSessionResourceVariants|ManagedAgentsGitHubRepositoryResourceShape|ManagedAgentsFileResourceShape|ManagedAgentsMemoryStoreResourceShape
 */
final class ManagedAgentsSessionResource implements ConverterSource
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
