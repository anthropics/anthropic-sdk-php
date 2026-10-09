<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can start workflow runs.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsEnabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsEnabled
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsDisabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsDisabled
 *
 * @phpstan-type BetaManagedAgentsMultiagentWorkflowsVariants = BetaManagedAgentsMultiagentWorkflowsEnabled|BetaManagedAgentsMultiagentWorkflowsDisabled
 * @phpstan-type BetaManagedAgentsMultiagentWorkflowsShape = BetaManagedAgentsMultiagentWorkflowsVariants|BetaManagedAgentsMultiagentWorkflowsEnabledShape|BetaManagedAgentsMultiagentWorkflowsDisabledShape
 */
final class BetaManagedAgentsMultiagentWorkflows implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentWorkflowsEnabled::class,
            'disabled' => BetaManagedAgentsMultiagentWorkflowsDisabled::class,
        ];
    }
}
