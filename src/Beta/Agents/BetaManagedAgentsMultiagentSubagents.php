<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can spawn session threads.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsEnabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsEnabled
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsDisabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsDisabled
 *
 * @phpstan-type BetaManagedAgentsMultiagentSubagentsVariants = BetaManagedAgentsMultiagentSubagentsEnabled|BetaManagedAgentsMultiagentSubagentsDisabled
 * @phpstan-type BetaManagedAgentsMultiagentSubagentsShape = BetaManagedAgentsMultiagentSubagentsVariants|BetaManagedAgentsMultiagentSubagentsEnabledShape|BetaManagedAgentsMultiagentSubagentsDisabledShape
 */
final class BetaManagedAgentsMultiagentSubagents implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentSubagentsEnabled::class,
            'disabled' => BetaManagedAgentsMultiagentSubagentsDisabled::class,
        ];
    }
}
