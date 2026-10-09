<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsDisabled;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can start workflow runs.
 *
 * @phpstan-import-type BetaManagedAgentsSessionMultiagentWorkflowsEnabledShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentWorkflowsEnabled
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsDisabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsDisabled
 *
 * @phpstan-type BetaManagedAgentsSessionMultiagentWorkflowsVariants = BetaManagedAgentsSessionMultiagentWorkflowsEnabled|BetaManagedAgentsMultiagentWorkflowsDisabled
 * @phpstan-type BetaManagedAgentsSessionMultiagentWorkflowsShape = BetaManagedAgentsSessionMultiagentWorkflowsVariants|BetaManagedAgentsSessionMultiagentWorkflowsEnabledShape|BetaManagedAgentsMultiagentWorkflowsDisabledShape
 */
final class BetaManagedAgentsSessionMultiagentWorkflows implements ConverterSource
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
            'enabled' => BetaManagedAgentsSessionMultiagentWorkflowsEnabled::class,
            'disabled' => BetaManagedAgentsMultiagentWorkflowsDisabled::class,
        ];
    }
}
