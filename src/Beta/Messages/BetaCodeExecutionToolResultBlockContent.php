<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaCodeExecutionToolResultErrorObjectShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultErrorObject
 * @phpstan-import-type BetaCodeExecutionResultBlockShape from \Anthropic\Beta\Messages\BetaCodeExecutionResultBlock
 * @phpstan-import-type BetaEncryptedCodeExecutionResultBlockShape from \Anthropic\Beta\Messages\BetaEncryptedCodeExecutionResultBlock
 *
 * @phpstan-type BetaCodeExecutionToolResultBlockContentVariants = BetaCodeExecutionToolResultErrorObject|BetaCodeExecutionResultBlock|BetaEncryptedCodeExecutionResultBlock
 * @phpstan-type BetaCodeExecutionToolResultBlockContentShape = BetaCodeExecutionToolResultBlockContentVariants|BetaCodeExecutionToolResultErrorObjectShape|BetaCodeExecutionResultBlockShape|BetaEncryptedCodeExecutionResultBlockShape
 */
final class BetaCodeExecutionToolResultBlockContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaCodeExecutionToolResultErrorObject::class,
            BetaCodeExecutionResultBlock::class,
            BetaEncryptedCodeExecutionResultBlock::class,
        ];
    }
}
