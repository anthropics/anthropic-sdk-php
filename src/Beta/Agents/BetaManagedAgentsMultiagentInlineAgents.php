<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can define inline agents. The agent defines an inline agent itself, in a workflow run's plan or when it spawns a session thread, and the inline agent is not saved.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsEnabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsEnabled
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsDisabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsDisabled
 *
 * @phpstan-type BetaManagedAgentsMultiagentInlineAgentsVariants = BetaManagedAgentsMultiagentInlineAgentsEnabled|BetaManagedAgentsMultiagentInlineAgentsDisabled
 * @phpstan-type BetaManagedAgentsMultiagentInlineAgentsShape = BetaManagedAgentsMultiagentInlineAgentsVariants|BetaManagedAgentsMultiagentInlineAgentsEnabledShape|BetaManagedAgentsMultiagentInlineAgentsDisabledShape
 */
final class BetaManagedAgentsMultiagentInlineAgents implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentInlineAgentsEnabled::class,
            'disabled' => BetaManagedAgentsMultiagentInlineAgentsDisabled::class,
        ];
    }
}
