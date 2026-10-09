<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the session's primary thread can consult an advisor model.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorEnabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorEnabled
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorDisabledShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorDisabled
 *
 * @phpstan-type BetaManagedAgentsMultiagentAdvisorVariants = BetaManagedAgentsMultiagentAdvisorEnabled|BetaManagedAgentsMultiagentAdvisorDisabled
 * @phpstan-type BetaManagedAgentsMultiagentAdvisorShape = BetaManagedAgentsMultiagentAdvisorVariants|BetaManagedAgentsMultiagentAdvisorEnabledShape|BetaManagedAgentsMultiagentAdvisorDisabledShape
 */
final class BetaManagedAgentsMultiagentAdvisor implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentAdvisorEnabled::class,
            'disabled' => BetaManagedAgentsMultiagentAdvisorDisabled::class,
        ];
    }
}
