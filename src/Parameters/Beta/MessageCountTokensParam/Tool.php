<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\MessageCountTokensParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\Beta\BetaCodeExecutionTool20250522;
use Anthropic\Models\Beta\BetaTool;
use Anthropic\Models\Beta\BetaToolBash20241022;
use Anthropic\Models\Beta\BetaToolBash20250124;
use Anthropic\Models\Beta\BetaToolComputerUse20241022;
use Anthropic\Models\Beta\BetaToolComputerUse20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20241022;
use Anthropic\Models\Beta\BetaToolTextEditor20250124;
use Anthropic\Models\Beta\BetaToolTextEditor20250429;
use Anthropic\Models\Beta\BetaToolTextEditor20250728;
use Anthropic\Models\Beta\BetaWebSearchTool20250305;

/**
 * @phpstan-type tool_alias = BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305
 */
final class Tool implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [
            BetaTool::class,
            BetaToolBash20241022::class,
            BetaToolBash20250124::class,
            BetaCodeExecutionTool20250522::class,
            BetaToolComputerUse20241022::class,
            BetaToolComputerUse20250124::class,
            BetaToolTextEditor20241022::class,
            BetaToolTextEditor20250124::class,
            BetaToolTextEditor20250429::class,
            BetaToolTextEditor20250728::class,
            BetaWebSearchTool20250305::class,
        ];
    }
}
