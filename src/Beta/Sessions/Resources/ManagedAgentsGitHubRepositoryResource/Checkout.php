<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Resources\ManagedAgentsGitHubRepositoryResource;

use Anthropic\Beta\Sessions\BetaManagedAgentsBranchCheckout;
use Anthropic\Beta\Sessions\BetaManagedAgentsCommitCheckout;
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
}
