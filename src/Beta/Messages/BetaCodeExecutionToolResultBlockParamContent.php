<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Code execution result with encrypted stdout for PFC + web_search results.
 *
 * @phpstan-import-type BetaCodeExecutionToolResultErrorParamShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultErrorParam
 * @phpstan-import-type BetaCodeExecutionResultBlockParamShape from \Anthropic\Beta\Messages\BetaCodeExecutionResultBlockParam
 * @phpstan-import-type BetaEncryptedCodeExecutionResultBlockParamShape from \Anthropic\Beta\Messages\BetaEncryptedCodeExecutionResultBlockParam
 *
 * @phpstan-type BetaCodeExecutionToolResultBlockParamContentVariants = BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam|BetaEncryptedCodeExecutionResultBlockParam
 * @phpstan-type BetaCodeExecutionToolResultBlockParamContentShape = BetaCodeExecutionToolResultBlockParamContentVariants|BetaCodeExecutionToolResultErrorParamShape|BetaCodeExecutionResultBlockParamShape|BetaEncryptedCodeExecutionResultBlockParamShape
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
            BetaEncryptedCodeExecutionResultBlockParam::class,
        ];
    }
}
