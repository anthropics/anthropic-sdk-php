<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration for a specific agent tool.
 *
 * @phpstan-import-type BetaManagedAgentsBashToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsBashToolConfig
 * @phpstan-import-type BetaManagedAgentsEditToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsEditToolConfig
 * @phpstan-import-type BetaManagedAgentsReadToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsReadToolConfig
 * @phpstan-import-type BetaManagedAgentsWriteToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsWriteToolConfig
 * @phpstan-import-type BetaManagedAgentsGlobToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsGlobToolConfig
 * @phpstan-import-type BetaManagedAgentsGrepToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsGrepToolConfig
 * @phpstan-import-type BetaManagedAgentsWebFetchToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchToolConfig
 * @phpstan-import-type BetaManagedAgentsWebSearchToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebSearchToolConfig
 *
 * @phpstan-type BetaManagedAgentsAgentToolConfigVariants = BetaManagedAgentsBashToolConfig|BetaManagedAgentsEditToolConfig|BetaManagedAgentsReadToolConfig|BetaManagedAgentsWriteToolConfig|BetaManagedAgentsGlobToolConfig|BetaManagedAgentsGrepToolConfig|BetaManagedAgentsWebFetchToolConfig|BetaManagedAgentsWebSearchToolConfig
 * @phpstan-type BetaManagedAgentsAgentToolConfigShape = BetaManagedAgentsAgentToolConfigVariants|BetaManagedAgentsBashToolConfigShape|BetaManagedAgentsEditToolConfigShape|BetaManagedAgentsReadToolConfigShape|BetaManagedAgentsWriteToolConfigShape|BetaManagedAgentsGlobToolConfigShape|BetaManagedAgentsGrepToolConfigShape|BetaManagedAgentsWebFetchToolConfigShape|BetaManagedAgentsWebSearchToolConfigShape
 */
final class BetaManagedAgentsAgentToolConfig implements ConverterSource
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
            'bash' => BetaManagedAgentsBashToolConfig::class,
            'edit' => BetaManagedAgentsEditToolConfig::class,
            'read' => BetaManagedAgentsReadToolConfig::class,
            'write' => BetaManagedAgentsWriteToolConfig::class,
            'glob' => BetaManagedAgentsGlobToolConfig::class,
            'grep' => BetaManagedAgentsGrepToolConfig::class,
            'web_fetch' => BetaManagedAgentsWebFetchToolConfig::class,
            'web_search' => BetaManagedAgentsWebSearchToolConfig::class,
        ];
    }
}
