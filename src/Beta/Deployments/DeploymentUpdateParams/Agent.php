<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\DeploymentUpdateParams;

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Agent to deploy. Accepts the `agent` ID string, which re-pins to the latest version, or an `agent` object with both id and version specified. Omit to preserve. Cannot be cleared.
 *
 * @phpstan-import-type BetaManagedAgentsAgentParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams
 *
 * @phpstan-type AgentVariants = string|BetaManagedAgentsAgentParams
 * @phpstan-type AgentShape = AgentVariants|BetaManagedAgentsAgentParamsShape
 */
final class Agent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return ['string', BetaManagedAgentsAgentParams::class];
    }
}
