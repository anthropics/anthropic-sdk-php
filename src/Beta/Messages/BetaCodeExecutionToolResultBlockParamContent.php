<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaCodeExecutionToolResultErrorParamShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultErrorParam
 * @phpstan-import-type BetaCodeExecutionResultBlockParamShape from \Anthropic\Beta\Messages\BetaCodeExecutionResultBlockParam
 *
 * @phpstan-type BetaCodeExecutionToolResultBlockParamContentShape = BetaCodeExecutionToolResultErrorParamShape|BetaCodeExecutionResultBlockParamShape
 */
final class BetaCodeExecutionToolResultBlockParamContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaCodeExecutionToolResultErrorParam::class,
            BetaCodeExecutionResultBlockParam::class,
        ];
    }
}
