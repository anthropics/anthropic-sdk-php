<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolUseBlockParam;

use Anthropic\Beta\Messages\BetaDirectCaller;
use Anthropic\Beta\Messages\BetaServerToolCaller;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Tool invocation directly from the model.
 *
 * @phpstan-import-type BetaDirectCallerShape from \Anthropic\Beta\Messages\BetaDirectCaller
 * @phpstan-import-type BetaServerToolCallerShape from \Anthropic\Beta\Messages\BetaServerToolCaller
 *
 * @phpstan-type CallerShape = BetaDirectCallerShape|BetaServerToolCallerShape
 */
final class Caller implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'direct' => BetaDirectCaller::class,
            'code_execution_20250825' => BetaServerToolCaller::class,
        ];
    }
}
