<?php

declare(strict_types=1);

namespace Anthropic\Messages\TextEditorCodeExecutionToolResultBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\TextEditorCodeExecutionCreateResultBlock;
use Anthropic\Messages\TextEditorCodeExecutionStrReplaceResultBlock;
use Anthropic\Messages\TextEditorCodeExecutionToolResultError;
use Anthropic\Messages\TextEditorCodeExecutionViewResultBlock;

/**
 * @phpstan-import-type TextEditorCodeExecutionToolResultErrorShape from \Anthropic\Messages\TextEditorCodeExecutionToolResultError
 * @phpstan-import-type TextEditorCodeExecutionViewResultBlockShape from \Anthropic\Messages\TextEditorCodeExecutionViewResultBlock
 * @phpstan-import-type TextEditorCodeExecutionCreateResultBlockShape from \Anthropic\Messages\TextEditorCodeExecutionCreateResultBlock
 * @phpstan-import-type TextEditorCodeExecutionStrReplaceResultBlockShape from \Anthropic\Messages\TextEditorCodeExecutionStrReplaceResultBlock
 *
 * @phpstan-type ContentVariants = TextEditorCodeExecutionToolResultError|TextEditorCodeExecutionViewResultBlock|TextEditorCodeExecutionCreateResultBlock|TextEditorCodeExecutionStrReplaceResultBlock
 * @phpstan-type ContentShape = ContentVariants|TextEditorCodeExecutionToolResultErrorShape|TextEditorCodeExecutionViewResultBlockShape|TextEditorCodeExecutionCreateResultBlockShape|TextEditorCodeExecutionStrReplaceResultBlockShape
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            TextEditorCodeExecutionToolResultError::class,
            TextEditorCodeExecutionViewResultBlock::class,
            TextEditorCodeExecutionCreateResultBlock::class,
            TextEditorCodeExecutionStrReplaceResultBlock::class,
        ];
    }
}
