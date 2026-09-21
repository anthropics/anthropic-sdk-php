<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments;

use Anthropic\Beta\Deployments\BetaManagedAgentsMemoryStoreResourceConfig\Access;
use Anthropic\Beta\Deployments\BetaManagedAgentsSessionResourceConfig\Type;
use Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A configured session resource. Echoes the input minus write-only credentials.
 *
 * @phpstan-import-type BetaManagedAgentsGitHubRepositoryResourceConfigShape from \Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig
 * @phpstan-import-type BetaManagedAgentsFileResourceConfigShape from \Anthropic\Beta\Deployments\BetaManagedAgentsFileResourceConfig
 * @phpstan-import-type BetaManagedAgentsMemoryStoreResourceConfigShape from \Anthropic\Beta\Deployments\BetaManagedAgentsMemoryStoreResourceConfig
 * @phpstan-import-type CheckoutShape from \Anthropic\Beta\Deployments\BetaManagedAgentsGitHubRepositoryResourceConfig\Checkout
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CheckoutShape|null $checkout
     * @param Access|value-of<Access>|null $access
     *
     * @return ($type is Type::GITHUB_REPOSITORY|'github_repository' ? BetaManagedAgentsGitHubRepositoryResourceConfig : ($type is Type::FILE|'file' ? BetaManagedAgentsFileResourceConfig : ($type is Type::MEMORY_STORE|'memory_store' ? BetaManagedAgentsMemoryStoreResourceConfig : BetaManagedAgentsGitHubRepositoryResourceConfig|BetaManagedAgentsFileResourceConfig|BetaManagedAgentsMemoryStoreResourceConfig)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $url = null,
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout = null,
        ?string $mountPath = null,
        ?string $fileID = null,
        ?string $memoryStoreID = null,
        Access|string|null $access = null,
        ?string $instructions = null,
    ): BetaManagedAgentsGitHubRepositoryResourceConfig|BetaManagedAgentsFileResourceConfig|BetaManagedAgentsMemoryStoreResourceConfig {
        return match ($type) {
            Type::GITHUB_REPOSITORY, 'github_repository' => BetaManagedAgentsGitHubRepositoryResourceConfig::with(
                type: 'github_repository',
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                checkout: $checkout,
                mountPath: $mountPath,
            ),
            Type::FILE, 'file' => BetaManagedAgentsFileResourceConfig::with(
                type: 'file',
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
                mountPath: $mountPath,
            ),
            Type::MEMORY_STORE, 'memory_store' => BetaManagedAgentsMemoryStoreResourceConfig::with(
                type: 'memory_store',
                memoryStoreID: $memoryStoreID ?? throw new \ArgumentCountError('$memoryStoreID is required'),
                access: $access,
                instructions: $instructions,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
