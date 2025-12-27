<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlock;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionCreateResultBlock;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionStrReplaceResultBlock;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultError;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextEditorCodeExecutionToolResultErrorShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultError
 * @phpstan-import-type BetaTextEditorCodeExecutionViewResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlock
 * @phpstan-import-type BetaTextEditorCodeExecutionCreateResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionCreateResultBlock
 * @phpstan-import-type BetaTextEditorCodeExecutionStrReplaceResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionStrReplaceResultBlock
 *
 * @phpstan-type ContentShape = BetaTextEditorCodeExecutionToolResultErrorShape|BetaTextEditorCodeExecutionViewResultBlockShape|BetaTextEditorCodeExecutionCreateResultBlockShape|BetaTextEditorCodeExecutionStrReplaceResultBlockShape
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
            BetaTextEditorCodeExecutionToolResultError::class,
            BetaTextEditorCodeExecutionViewResultBlock::class,
            BetaTextEditorCodeExecutionCreateResultBlock::class,
            BetaTextEditorCodeExecutionStrReplaceResultBlock::class,
        ];
    }
}
