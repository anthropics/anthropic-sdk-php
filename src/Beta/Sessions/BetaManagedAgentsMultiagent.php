<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagent20261001;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Resolved multiagent orchestration configuration as returned in API responses.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentCoordinatorShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator
 * @phpstan-import-type BetaManagedAgentsMultiagent20261001Shape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagent20261001
 *
 * @phpstan-type BetaManagedAgentsMultiagentVariants = BetaManagedAgentsMultiagentCoordinator|BetaManagedAgentsMultiagent20261001
 * @phpstan-type BetaManagedAgentsMultiagentShape = BetaManagedAgentsMultiagentVariants|BetaManagedAgentsMultiagentCoordinatorShape|BetaManagedAgentsMultiagent20261001Shape
 */
final class BetaManagedAgentsMultiagent implements ConverterSource
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
            'coordinator' => BetaManagedAgentsMultiagentCoordinator::class,
            'multiagent_20261001' => BetaManagedAgentsMultiagent20261001::class,
        ];
    }
}
