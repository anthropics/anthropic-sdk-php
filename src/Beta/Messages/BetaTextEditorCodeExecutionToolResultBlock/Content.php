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

final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
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
