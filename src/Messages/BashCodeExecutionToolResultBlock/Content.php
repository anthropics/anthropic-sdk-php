<?php

declare(strict_types=1);

namespace Anthropic\Messages\BashCodeExecutionToolResultBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\BashCodeExecutionResultBlock;
use Anthropic\Messages\BashCodeExecutionToolResultError;

/**
 * @phpstan-import-type BashCodeExecutionToolResultErrorShape from \Anthropic\Messages\BashCodeExecutionToolResultError
 * @phpstan-import-type BashCodeExecutionResultBlockShape from \Anthropic\Messages\BashCodeExecutionResultBlock
 *
 * @phpstan-type ContentVariants = BashCodeExecutionToolResultError|BashCodeExecutionResultBlock
 * @phpstan-type ContentShape = ContentVariants|BashCodeExecutionToolResultErrorShape|BashCodeExecutionResultBlockShape
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
            BashCodeExecutionToolResultError::class,
            BashCodeExecutionResultBlock::class,
        ];
    }
}
