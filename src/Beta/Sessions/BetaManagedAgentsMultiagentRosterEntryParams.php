<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSelfParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * An entry in a multiagent roster: an agent ID string, a versioned agent reference, or `self`.
 *
 * @phpstan-import-type BetaManagedAgentsAgentParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams
 * @phpstan-import-type BetaManagedAgentsMultiagentSelfParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSelfParams
 * @phpstan-import-type BetaManagedAgentsAdvisorParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAdvisorParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentRosterEntryParamsVariants = string|BetaManagedAgentsAgentParams|BetaManagedAgentsMultiagentSelfParams|BetaManagedAgentsAdvisorParams
 * @phpstan-type BetaManagedAgentsMultiagentRosterEntryParamsShape = BetaManagedAgentsMultiagentRosterEntryParamsVariants|BetaManagedAgentsAgentParamsShape|BetaManagedAgentsMultiagentSelfParamsShape|BetaManagedAgentsAdvisorParamsShape
 */
final class BetaManagedAgentsMultiagentRosterEntryParams implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'string',
            BetaManagedAgentsAgentParams::class,
            BetaManagedAgentsMultiagentSelfParams::class,
            BetaManagedAgentsAdvisorParams::class,
        ];
    }
}
