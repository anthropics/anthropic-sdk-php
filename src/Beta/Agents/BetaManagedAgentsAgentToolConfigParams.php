<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration override for a specific tool within a toolset.
 *
 * @phpstan-import-type BetaManagedAgentsBashToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfigParams
 * @phpstan-import-type BetaManagedAgentsEditToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsEditToolConfigParams
 * @phpstan-import-type BetaManagedAgentsReadToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsReadToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWriteToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWriteToolConfigParams
 * @phpstan-import-type BetaManagedAgentsGlobToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfigParams
 * @phpstan-import-type BetaManagedAgentsGrepToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWebFetchToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWebSearchToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfigParams
 *
 * @phpstan-type BetaManagedAgentsAgentToolConfigParamsVariants = BetaManagedAgentsBashToolConfigParams|BetaManagedAgentsEditToolConfigParams|BetaManagedAgentsReadToolConfigParams|BetaManagedAgentsWriteToolConfigParams|BetaManagedAgentsGlobToolConfigParams|BetaManagedAgentsGrepToolConfigParams|BetaManagedAgentsWebFetchToolConfigParams|BetaManagedAgentsWebSearchToolConfigParams
 * @phpstan-type BetaManagedAgentsAgentToolConfigParamsShape = BetaManagedAgentsAgentToolConfigParamsVariants|BetaManagedAgentsBashToolConfigParamsShape|BetaManagedAgentsEditToolConfigParamsShape|BetaManagedAgentsReadToolConfigParamsShape|BetaManagedAgentsWriteToolConfigParamsShape|BetaManagedAgentsGlobToolConfigParamsShape|BetaManagedAgentsGrepToolConfigParamsShape|BetaManagedAgentsWebFetchToolConfigParamsShape|BetaManagedAgentsWebSearchToolConfigParamsShape
 */
final class BetaManagedAgentsAgentToolConfigParams implements ConverterSource
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
            'bash' => BetaManagedAgentsBashToolConfigParams::class,
            'edit' => BetaManagedAgentsEditToolConfigParams::class,
            'read' => BetaManagedAgentsReadToolConfigParams::class,
            'write' => BetaManagedAgentsWriteToolConfigParams::class,
            'glob' => BetaManagedAgentsGlobToolConfigParams::class,
            'grep' => BetaManagedAgentsGrepToolConfigParams::class,
            'web_fetch' => BetaManagedAgentsWebFetchToolConfigParams::class,
            'web_search' => BetaManagedAgentsWebSearchToolConfigParams::class,
        ];
    }
}
