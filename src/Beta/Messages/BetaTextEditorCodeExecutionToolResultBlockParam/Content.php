<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlockParam;

use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionCreateResultBlockParam;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionStrReplaceResultBlockParam;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorParam;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlockParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextEditorCodeExecutionToolResultErrorParamShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultErrorParam
 * @phpstan-import-type BetaTextEditorCodeExecutionViewResultBlockParamShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlockParam
 * @phpstan-import-type BetaTextEditorCodeExecutionCreateResultBlockParamShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionCreateResultBlockParam
 * @phpstan-import-type BetaTextEditorCodeExecutionStrReplaceResultBlockParamShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionStrReplaceResultBlockParam
 *
 * @phpstan-type ContentShape = BetaTextEditorCodeExecutionToolResultErrorParamShape|BetaTextEditorCodeExecutionViewResultBlockParamShape|BetaTextEditorCodeExecutionCreateResultBlockParamShape|BetaTextEditorCodeExecutionStrReplaceResultBlockParamShape
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
            BetaTextEditorCodeExecutionToolResultErrorParam::class,
            BetaTextEditorCodeExecutionViewResultBlockParam::class,
            BetaTextEditorCodeExecutionCreateResultBlockParam::class,
            BetaTextEditorCodeExecutionStrReplaceResultBlockParam::class,
        ];
    }
}
