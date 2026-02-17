<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Code execution result with encrypted stdout for PFC + web_search results.
 *
 * @phpstan-import-type CodeExecutionToolResultErrorParamShape from \Anthropic\Messages\CodeExecutionToolResultErrorParam
 * @phpstan-import-type CodeExecutionResultBlockParamShape from \Anthropic\Messages\CodeExecutionResultBlockParam
 * @phpstan-import-type EncryptedCodeExecutionResultBlockParamShape from \Anthropic\Messages\EncryptedCodeExecutionResultBlockParam
 *
 * @phpstan-type CodeExecutionToolResultBlockParamContentVariants = CodeExecutionToolResultErrorParam|CodeExecutionResultBlockParam|EncryptedCodeExecutionResultBlockParam
 * @phpstan-type CodeExecutionToolResultBlockParamContentShape = CodeExecutionToolResultBlockParamContentVariants|CodeExecutionToolResultErrorParamShape|CodeExecutionResultBlockParamShape|EncryptedCodeExecutionResultBlockParamShape
 */
final class CodeExecutionToolResultBlockParamContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            CodeExecutionToolResultErrorParam::class,
            CodeExecutionResultBlockParam::class,
            EncryptedCodeExecutionResultBlockParam::class,
        ];
    }
}
