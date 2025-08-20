<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type beta_code_execution_tool_result_block_param_content_alias = BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam
 */
final class BetaCodeExecutionToolResultBlockParamContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return [
            BetaCodeExecutionToolResultErrorParam::class,
            BetaCodeExecutionResultBlockParam::class,
        ];
    }
}
