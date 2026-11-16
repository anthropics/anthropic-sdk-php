<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlock;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionCreateResultBlock;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionStrReplaceResultBlock;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorObject;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextEditorCodeExecutionToolResultErrorObjectShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorObject
 * @phpstan-import-type BetaTextEditorCodeExecutionViewResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock
 * @phpstan-import-type BetaTextEditorCodeExecutionCreateResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionCreateResultBlock
 * @phpstan-import-type BetaTextEditorCodeExecutionStrReplaceResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionStrReplaceResultBlock
 *
 * @phpstan-type ContentVariants = BetaTextEditorCodeExecutionToolResultErrorObject|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock
 * @phpstan-type ContentShape = ContentVariants|BetaTextEditorCodeExecutionToolResultErrorObjectShape|BetaTextEditorCodeExecutionViewResultBlockShape|BetaTextEditorCodeExecutionCreateResultBlockShape|BetaTextEditorCodeExecutionStrReplaceResultBlockShape
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
            BetaTextEditorCodeExecutionToolResultErrorObject::class,
            BetaTextEditorCodeExecutionViewResultBlock::class,
            BetaTextEditorCodeExecutionCreateResultBlock::class,
            BetaTextEditorCodeExecutionStrReplaceResultBlock::class,
        ];
    }
}
