<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaCodeExecutionToolResultErrorShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultError
 * @phpstan-import-type BetaCodeExecutionResultBlockShape from \Anthropic\Beta\Messages\BetaCodeExecutionResultBlock
 *
 * @phpstan-type BetaCodeExecutionToolResultBlockContentShape = BetaCodeExecutionToolResultErrorShape|BetaCodeExecutionResultBlockShape
 */
final class BetaCodeExecutionToolResultBlockContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaCodeExecutionToolResultError::class,
            BetaCodeExecutionResultBlock::class,
        ];
    }
}
