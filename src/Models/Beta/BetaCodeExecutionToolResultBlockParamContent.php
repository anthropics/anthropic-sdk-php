<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_code_execution_tool_result_block_param_content_alias = BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam
 */
final class BetaCodeExecutionToolResultBlockParamContent implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [
            BetaCodeExecutionToolResultErrorParam::class,
            BetaCodeExecutionResultBlockParam::class,
        ];
    }
}
