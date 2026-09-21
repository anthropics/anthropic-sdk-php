<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\DeploymentCreateParams;

use Anthropic\Beta\Deployments\DeploymentCreateParams\Resource\Type;
use Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsFileResourceParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsMemoryStoreResourceParam;
use Anthropic\Beta\Sessions\BetaManagedAgentsMemoryStoreResourceParam\Access;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union of resources that can be mounted into a session.
 *
 * @phpstan-import-type BetaManagedAgentsGitHubRepositoryResourceParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams
 * @phpstan-import-type BetaManagedAgentsFileResourceParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsFileResourceParams
 * @phpstan-import-type BetaManagedAgentsMemoryStoreResourceParamShape from \Anthropic\Beta\Sessions\BetaManagedAgentsMemoryStoreResourceParam
 * @phpstan-import-type CheckoutShape from \Anthropic\Beta\Sessions\BetaManagedAgentsGitHubRepositoryResourceParams\Checkout
 *
 * @phpstan-type ResourceVariants = BetaManagedAgentsGitHubRepositoryResourceParams|BetaManagedAgentsFileResourceParams|BetaManagedAgentsMemoryStoreResourceParam
 * @phpstan-type ResourceShape = ResourceVariants|BetaManagedAgentsGitHubRepositoryResourceParamsShape|BetaManagedAgentsFileResourceParamsShape|BetaManagedAgentsMemoryStoreResourceParamShape
 */
final class Resource implements ConverterSource
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
            'github_repository' => BetaManagedAgentsGitHubRepositoryResourceParams::class,
            'file' => BetaManagedAgentsFileResourceParams::class,
            'memory_store' => BetaManagedAgentsMemoryStoreResourceParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CheckoutShape|null $checkout
     * @param Access|value-of<Access>|null $access
     *
     * @return ($type is Type::GITHUB_REPOSITORY|'github_repository' ? BetaManagedAgentsGitHubRepositoryResourceParams : ($type is Type::FILE|'file' ? BetaManagedAgentsFileResourceParams : ($type is Type::MEMORY_STORE|'memory_store' ? BetaManagedAgentsMemoryStoreResourceParam : BetaManagedAgentsGitHubRepositoryResourceParams|BetaManagedAgentsFileResourceParams|BetaManagedAgentsMemoryStoreResourceParam)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $url = null,
        ?string $authorizationToken = null,
        BetaManagedAgentsBranchCheckout|array|BetaManagedAgentsCommitCheckout|null $checkout = null,
        ?string $mountPath = null,
        ?string $fileID = null,
        ?string $memoryStoreID = null,
        Access|string|null $access = null,
        ?string $instructions = null,
    ): BetaManagedAgentsGitHubRepositoryResourceParams|BetaManagedAgentsFileResourceParams|BetaManagedAgentsMemoryStoreResourceParam {
        return match ($type) {
            Type::GITHUB_REPOSITORY, 'github_repository' => BetaManagedAgentsGitHubRepositoryResourceParams::with(
                type: 'github_repository',
                url: $url ?? throw new \ArgumentCountError('$url is required'),
                authorizationToken: $authorizationToken,
                checkout: $checkout,
                mountPath: $mountPath,
            ),
            Type::FILE, 'file' => BetaManagedAgentsFileResourceParams::with(
                type: 'file',
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
                mountPath: $mountPath,
            ),
            Type::MEMORY_STORE, 'memory_store' => BetaManagedAgentsMemoryStoreResourceParam::with(
                type: 'memory_store',
                memoryStoreID: $memoryStoreID ?? throw new \ArgumentCountError('$memoryStoreID is required'),
                access: $access,
                instructions: $instructions,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
