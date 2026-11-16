<?php

declare(strict_types=1);

namespace Anthropic\Messages\BashCodeExecutionToolResultBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\BashCodeExecutionResultBlock;
use Anthropic\Messages\BashCodeExecutionToolResultErrorObject;

/**
 * @phpstan-import-type BashCodeExecutionToolResultErrorObjectShape from \Anthropic\Messages\BashCodeExecutionToolResultErrorObject
 * @phpstan-import-type BashCodeExecutionResultBlockShape from \Anthropic\Messages\BashCodeExecutionResultBlock
 *
 * @phpstan-type ContentVariants = BashCodeExecutionToolResultErrorObject|BashCodeExecutionResultBlock
 * @phpstan-type ContentShape = ContentVariants|BashCodeExecutionToolResultErrorObjectShape|BashCodeExecutionResultBlockShape
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
            BashCodeExecutionToolResultErrorObject::class,
            BashCodeExecutionResultBlock::class,
        ];
    }
}
