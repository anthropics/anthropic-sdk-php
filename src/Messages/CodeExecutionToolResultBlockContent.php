<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type CodeExecutionToolResultErrorObjectShape from \Anthropic\Messages\CodeExecutionToolResultErrorObject
 * @phpstan-import-type CodeExecutionResultBlockShape from \Anthropic\Messages\CodeExecutionResultBlock
 * @phpstan-import-type EncryptedCodeExecutionResultBlockShape from \Anthropic\Messages\EncryptedCodeExecutionResultBlock
 *
 * @phpstan-type CodeExecutionToolResultBlockContentVariants = CodeExecutionToolResultErrorObject|CodeExecutionResultBlock|EncryptedCodeExecutionResultBlock
 * @phpstan-type CodeExecutionToolResultBlockContentShape = CodeExecutionToolResultBlockContentVariants|CodeExecutionToolResultErrorObjectShape|CodeExecutionResultBlockShape|EncryptedCodeExecutionResultBlockShape
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
            CodeExecutionToolResultErrorObject::class,
            CodeExecutionResultBlock::class,
            EncryptedCodeExecutionResultBlock::class,
        ];
    }
}
