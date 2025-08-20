<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\MessageCountTokensParams;

use Anthropic\Beta\Messages\BetaCodeExecutionTool20250522;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaToolBash20241022;
use Anthropic\Beta\Messages\BetaToolBash20250124;
use Anthropic\Beta\Messages\BetaToolComputerUse20241022;
use Anthropic\Beta\Messages\BetaToolComputerUse20250124;
use Anthropic\Beta\Messages\BetaToolTextEditor20241022;
use Anthropic\Beta\Messages\BetaToolTextEditor20250124;
use Anthropic\Beta\Messages\BetaToolTextEditor20250429;
use Anthropic\Beta\Messages\BetaToolTextEditor20250728;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type tool_alias = BetaTool|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaToolComputerUse20241022|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305
 */
final class Tool implements ConverterSource
{
    use SdkUnion;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
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
