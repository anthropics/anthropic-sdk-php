<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Code execution result with encrypted stdout for PFC + web_search results.
 *
 * @phpstan-import-type CodeExecutionToolResultErrorShape from \Anthropic\Messages\CodeExecutionToolResultError
 * @phpstan-import-type CodeExecutionResultBlockShape from \Anthropic\Messages\CodeExecutionResultBlock
 * @phpstan-import-type EncryptedCodeExecutionResultBlockShape from \Anthropic\Messages\EncryptedCodeExecutionResultBlock
 *
 * @phpstan-type CodeExecutionToolResultBlockContentVariants = CodeExecutionToolResultError|CodeExecutionResultBlock|EncryptedCodeExecutionResultBlock
 * @phpstan-type CodeExecutionToolResultBlockContentShape = CodeExecutionToolResultBlockContentVariants|CodeExecutionToolResultErrorShape|CodeExecutionResultBlockShape|EncryptedCodeExecutionResultBlockShape
 */
final class CodeExecutionToolResultBlockContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            CodeExecutionToolResultError::class,
            CodeExecutionResultBlock::class,
            EncryptedCodeExecutionResultBlock::class,
        ];
    }
}
