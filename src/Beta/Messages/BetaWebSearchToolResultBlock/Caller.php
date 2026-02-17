<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebSearchToolResultBlock;

use Anthropic\Beta\Messages\BetaDirectCaller;
use Anthropic\Beta\Messages\BetaServerToolCaller;
use Anthropic\Beta\Messages\BetaServerToolCaller20260120;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Tool invocation directly from the model.
 *
 * @phpstan-import-type BetaDirectCallerShape from \Anthropic\Beta\Messages\BetaDirectCaller
 * @phpstan-import-type BetaServerToolCallerShape from \Anthropic\Beta\Messages\BetaServerToolCaller
 * @phpstan-import-type BetaServerToolCaller20260120Shape from \Anthropic\Beta\Messages\BetaServerToolCaller20260120
 *
 * @phpstan-type CallerVariants = BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120
 * @phpstan-type CallerShape = CallerVariants|BetaDirectCallerShape|BetaServerToolCallerShape|BetaServerToolCaller20260120Shape
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
            'code_execution_20260120' => BetaServerToolCaller20260120::class,
        ];
    }
}
