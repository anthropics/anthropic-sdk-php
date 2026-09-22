<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A configured session resource. Echoes the input minus write-only credentials.
 *
 * @phpstan-import-type BetaManagedAgentsGitHubRepositoryResourceConfigShape from \Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig
 * @phpstan-import-type BetaManagedAgentsFileResourceConfigShape from \Anthropic\Beta\Deployments\BetaManagedAgentsFileResourceConfig
 * @phpstan-import-type BetaManagedAgentsMemoryStoreResourceConfigShape from \Anthropic\Beta\Deployments\BetaManagedAgentsMemoryStoreResourceConfig
 *
 * @phpstan-type BetaManagedAgentsSessionResourceConfigVariants = BetaManagedAgentsGitHubRepositoryResourceConfig|BetaManagedAgentsFileResourceConfig|BetaManagedAgentsMemoryStoreResourceConfig
 * @phpstan-type BetaManagedAgentsSessionResourceConfigShape = BetaManagedAgentsSessionResourceConfigVariants|BetaManagedAgentsGitHubRepositoryResourceConfigShape|BetaManagedAgentsFileResourceConfigShape|BetaManagedAgentsMemoryStoreResourceConfigShape
 */
final class BetaManagedAgentsSessionResourceConfig implements ConverterSource
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
            'github_repository' => BetaManagedAgentsGitHubRepositoryResourceConfig::class,
            'file' => BetaManagedAgentsFileResourceConfig::class,
            'memory_store' => BetaManagedAgentsMemoryStoreResourceConfig::class,
        ];
    }
}
