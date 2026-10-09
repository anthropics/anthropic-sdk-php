<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsDisabled;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can spawn session threads.
 *
 * @phpstan-import-type BetaManagedAgentsSessionMultiagentSubagentsEnabledShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentSubagentsEnabled
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsDisabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsDisabled
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagentSubagentsVariants = BetaManagedAgentsSessionMultiagentSubagentsEnabled|BetaManagedAgentsMultiagentSubagentsDisabled
 * @phpstan-type BetaManagedAgentsSessionMultiagentSubagentsShape = BetaManagedAgentsSessionMultiagentSubagentsVariants|BetaManagedAgentsSessionMultiagentSubagentsEnabledShape|BetaManagedAgentsMultiagentSubagentsDisabledShape
 */
final class BetaManagedAgentsSessionMultiagentSubagents implements ConverterSource
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
            'enabled' => BetaManagedAgentsSessionMultiagentSubagentsEnabled::class,
            'disabled' => BetaManagedAgentsMultiagentSubagentsDisabled::class,
        ];
    }
}
