<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Resolved multiagent orchestration configuration as returned on a `session`.
 *
 * @phpstan-import-type BetaManagedAgentsSessionMultiagentCoordinatorShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentCoordinator
 * @phpstan-import-type BetaManagedAgentsSessionMultiagent20261001Shape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagent20261001
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagentVariants = BetaManagedAgentsSessionMultiagentCoordinator|BetaManagedAgentsSessionMultiagent20261001
 * @phpstan-type BetaManagedAgentsSessionMultiagentShape = BetaManagedAgentsSessionMultiagentVariants|BetaManagedAgentsSessionMultiagentCoordinatorShape|BetaManagedAgentsSessionMultiagent20261001Shape
 */
final class BetaManagedAgentsSessionMultiagent implements ConverterSource
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
            'coordinator' => BetaManagedAgentsSessionMultiagentCoordinator::class,
            'multiagent_20261001' => BetaManagedAgentsSessionMultiagent20261001::class,
        ];
    }
}
