<?php

declare(strict_types=1);

namespace Anthropic\Messages\TextEditorCodeExecutionToolResultBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\TextEditorCodeExecutionCreateResultBlock;
use Anthropic\Messages\TextEditorCodeExecutionStrReplaceResultBlock;
use Anthropic\Messages\TextEditorCodeExecutionToolResultErrorObject;
use Anthropic\Messages\TextEditorCodeExecutionViewResultBlock;

/**
 * @phpstan-import-type TextEditorCodeExecutionToolResultErrorObjectShape from \Anthropic\Messages\TextEditorCodeExecutionToolResultErrorObject
 * @phpstan-import-type TextEditorCodeExecutionViewResultBlockShape from \Anthropic\Messages\TextEditorCodeExecutionViewResultBlock
 * @phpstan-import-type TextEditorCodeExecutionCreateResultBlockShape from \Anthropic\Messages\TextEditorCodeExecutionCreateResultBlock
 * @phpstan-import-type TextEditorCodeExecutionStrReplaceResultBlockShape from \Anthropic\Messages\TextEditorCodeExecutionStrReplaceResultBlock
 *
 * @phpstan-type ContentVariants = TextEditorCodeExecutionToolResultErrorObject|TextEditorCodeExecutionViewResultBlock|TextEditorCodeExecutionCreateResultBlock|TextEditorCodeExecutionStrReplaceResultBlock
 * @phpstan-type ContentShape = ContentVariants|TextEditorCodeExecutionToolResultErrorObjectShape|TextEditorCodeExecutionViewResultBlockShape|TextEditorCodeExecutionCreateResultBlockShape|TextEditorCodeExecutionStrReplaceResultBlockShape
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
            TextEditorCodeExecutionToolResultErrorObject::class,
            TextEditorCodeExecutionViewResultBlock::class,
            TextEditorCodeExecutionCreateResultBlock::class,
            TextEditorCodeExecutionStrReplaceResultBlock::class,
        ];
    }
}
