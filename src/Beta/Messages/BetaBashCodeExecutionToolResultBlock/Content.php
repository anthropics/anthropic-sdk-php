<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock;

use Anthropic\Beta\Messages\BetaBashCodeExecutionResultBlock;
use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultErrorObject;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBashCodeExecutionToolResultErrorObjectShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultErrorObject
 * @phpstan-import-type BetaBashCodeExecutionResultBlockShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionResultBlock
 *
 * @phpstan-type ContentVariants = BetaBashCodeExecutionToolResultErrorObject|BetaBashCodeExecutionResultBlock
 * @phpstan-type ContentShape = ContentVariants|BetaBashCodeExecutionToolResultErrorObjectShape|BetaBashCodeExecutionResultBlockShape
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
            BetaBashCodeExecutionToolResultErrorObject::class,
            BetaBashCodeExecutionResultBlock::class,
        ];
    }
}
