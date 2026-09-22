<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Describes what triggered a deployment run, with trigger-specific metadata.
 *
 * @phpstan-import-type BetaManagedAgentsScheduleTriggerContextShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsScheduleTriggerContext
 * @phpstan-import-type BetaManagedAgentsManualTriggerContextShape from \Anthropic\Beta\DeploymentRuns\BetaManagedAgentsManualTriggerContext
 *
 * @phpstan-type BetaManagedAgentsTriggerContextVariants = BetaManagedAgentsScheduleTriggerContext|BetaManagedAgentsManualTriggerContext
 * @phpstan-type BetaManagedAgentsTriggerContextShape = BetaManagedAgentsTriggerContextVariants|BetaManagedAgentsScheduleTriggerContextShape|BetaManagedAgentsManualTriggerContextShape
 */
final class BetaManagedAgentsTriggerContext implements ConverterSource
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
            'schedule' => BetaManagedAgentsScheduleTriggerContext::class,
            'manual' => BetaManagedAgentsManualTriggerContext::class,
        ];
    }
}
