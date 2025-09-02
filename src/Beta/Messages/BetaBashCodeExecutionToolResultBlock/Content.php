<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock;

use Anthropic\Beta\Messages\BetaBashCodeExecutionResultBlock;
use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultError;
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
            BetaBashCodeExecutionToolResultError::class,
            BetaBashCodeExecutionResultBlock::class,
        ];
    }
}
