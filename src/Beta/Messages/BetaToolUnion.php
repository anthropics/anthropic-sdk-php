<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class BetaToolUnion implements ConverterSource
{
    use SdkUnion;

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
