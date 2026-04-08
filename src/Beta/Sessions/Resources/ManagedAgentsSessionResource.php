<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsGitHubRepositoryResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource
 * @phpstan-import-type ManagedAgentsFileResourceShape from \Anthropic\Beta\Sessions\Resources\ManagedAgentsFileResource
 *
 * @phpstan-type ManagedAgentsSessionResourceVariants = ManagedAgentsGitHubRepositoryResource|ManagedAgentsFileResource
 * @phpstan-type ManagedAgentsSessionResourceShape = ManagedAgentsSessionResourceVariants|ManagedAgentsGitHubRepositoryResourceShape|ManagedAgentsFileResourceShape
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
        ];
    }
}
