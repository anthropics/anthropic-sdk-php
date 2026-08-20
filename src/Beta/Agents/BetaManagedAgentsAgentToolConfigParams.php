<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsBashToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsEditToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsGlobToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsGrepToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsReadToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsWebFetchToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsWebSearchToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsWriteToolConfigParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration override for a specific tool within a toolset.
 *
 * @phpstan-import-type BetaManagedAgentsBashToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsBashToolConfigParams
 * @phpstan-import-type BetaManagedAgentsEditToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsEditToolConfigParams
 * @phpstan-import-type BetaManagedAgentsReadToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsReadToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWriteToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsWriteToolConfigParams
 * @phpstan-import-type BetaManagedAgentsGlobToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsGlobToolConfigParams
 * @phpstan-import-type BetaManagedAgentsGrepToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsGrepToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWebFetchToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsWebFetchToolConfigParams
 * @phpstan-import-type BetaManagedAgentsWebSearchToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams\BetaManagedAgentsWebSearchToolConfigParams
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
