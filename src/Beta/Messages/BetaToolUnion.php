<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Configuration for a group of tools from an MCP server.
 *
 * Allows configuring enabled status and defer_loading for all tools
 * from an MCP server, with optional per-tool overrides.
 *
 * @phpstan-import-type BetaToolShape from \Anthropic\Beta\Messages\BetaTool
 * @phpstan-import-type BetaToolBash20241022Shape from \Anthropic\Beta\Messages\BetaToolBash20241022
 * @phpstan-import-type BetaToolBash20250124Shape from \Anthropic\Beta\Messages\BetaToolBash20250124
 * @phpstan-import-type BetaCodeExecutionTool20250522Shape from \Anthropic\Beta\Messages\BetaCodeExecutionTool20250522
 * @phpstan-import-type BetaCodeExecutionTool20250825Shape from \Anthropic\Beta\Messages\BetaCodeExecutionTool20250825
 * @phpstan-import-type BetaToolComputerUse20241022Shape from \Anthropic\Beta\Messages\BetaToolComputerUse20241022
 * @phpstan-import-type BetaMemoryTool20250818Shape from \Anthropic\Beta\Messages\BetaMemoryTool20250818
 * @phpstan-import-type BetaToolComputerUse20250124Shape from \Anthropic\Beta\Messages\BetaToolComputerUse20250124
 * @phpstan-import-type BetaToolTextEditor20241022Shape from \Anthropic\Beta\Messages\BetaToolTextEditor20241022
 * @phpstan-import-type BetaToolComputerUse20251124Shape from \Anthropic\Beta\Messages\BetaToolComputerUse20251124
 * @phpstan-import-type BetaToolTextEditor20250124Shape from \Anthropic\Beta\Messages\BetaToolTextEditor20250124
 * @phpstan-import-type BetaToolTextEditor20250429Shape from \Anthropic\Beta\Messages\BetaToolTextEditor20250429
 * @phpstan-import-type BetaToolTextEditor20250728Shape from \Anthropic\Beta\Messages\BetaToolTextEditor20250728
 * @phpstan-import-type BetaWebSearchTool20250305Shape from \Anthropic\Beta\Messages\BetaWebSearchTool20250305
 * @phpstan-import-type BetaWebFetchTool20250910Shape from \Anthropic\Beta\Messages\BetaWebFetchTool20250910
 * @phpstan-import-type BetaToolSearchToolBm25_20251119Shape from \Anthropic\Beta\Messages\BetaToolSearchToolBm25_20251119
 * @phpstan-import-type BetaToolSearchToolRegex20251119Shape from \Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119
 * @phpstan-import-type BetaMCPToolsetShape from \Anthropic\Beta\Messages\BetaMCPToolset
 *
 * @phpstan-type BetaToolUnionShape = BetaToolShape|BetaToolBash20241022Shape|BetaToolBash20250124Shape|BetaCodeExecutionTool20250522Shape|BetaCodeExecutionTool20250825Shape|BetaToolComputerUse20241022Shape|BetaMemoryTool20250818Shape|BetaToolComputerUse20250124Shape|BetaToolTextEditor20241022Shape|BetaToolComputerUse20251124Shape|BetaToolTextEditor20250124Shape|BetaToolTextEditor20250429Shape|BetaToolTextEditor20250728Shape|BetaWebSearchTool20250305Shape|BetaWebFetchTool20250910Shape|BetaToolSearchToolBm25_20251119Shape|BetaToolSearchToolRegex20251119Shape|BetaMCPToolsetShape
 */
final class BetaToolUnion implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaTool::class,
            BetaToolBash20241022::class,
            BetaToolBash20250124::class,
            BetaCodeExecutionTool20250522::class,
            BetaCodeExecutionTool20250825::class,
            BetaToolComputerUse20241022::class,
            BetaMemoryTool20250818::class,
            BetaToolComputerUse20250124::class,
            BetaToolTextEditor20241022::class,
            BetaToolComputerUse20251124::class,
            BetaToolTextEditor20250124::class,
            BetaToolTextEditor20250429::class,
            BetaToolTextEditor20250728::class,
            BetaWebSearchTool20250305::class,
            BetaWebFetchTool20250910::class,
            BetaToolSearchToolBm25_20251119::class,
            BetaToolSearchToolRegex20251119::class,
            BetaMCPToolset::class,
        ];
    }
}
