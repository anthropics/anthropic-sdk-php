<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource;

use Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout;
use Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource\Checkout\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaManagedAgentsBranchCheckoutShape from \Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout
 * @phpstan-import-type BetaManagedAgentsCommitCheckoutShape from \Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout
 *
 * @phpstan-type CheckoutVariants = BetaManagedAgentsBranchCheckout|BetaManagedAgentsCommitCheckout
 * @phpstan-type CheckoutShape = CheckoutVariants|BetaManagedAgentsBranchCheckoutShape|BetaManagedAgentsCommitCheckoutShape
 */
final class Checkout implements ConverterSource
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
            'branch' => BetaManagedAgentsBranchCheckout::class,
            'commit' => BetaManagedAgentsCommitCheckout::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::BRANCH|'branch' ? BetaManagedAgentsBranchCheckout : ($type is Type::COMMIT|'commit' ? BetaManagedAgentsCommitCheckout : BetaManagedAgentsBranchCheckout|BetaManagedAgentsCommitCheckout))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $name = null,
        ?string $sha = null,
    ): BetaManagedAgentsBranchCheckout|BetaManagedAgentsCommitCheckout {
        return match ($type) {
            Type::BRANCH, 'branch' => BetaManagedAgentsBranchCheckout::with(
                type: 'branch',
                name: $name ?? throw new \ArgumentCountError('$name is required'),
            ),
            Type::COMMIT, 'commit' => BetaManagedAgentsCommitCheckout::with(
                type: 'commit',
                sha: $sha ?? throw new \ArgumentCountError('$sha is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
