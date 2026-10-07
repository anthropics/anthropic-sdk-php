<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which party invoked the tool call: the model directly, or a server tool on its behalf.
 *
 * @phpstan-import-type BetaDirectCallerShape from \Anthropic\Beta\Messages\BetaDirectCaller
 * @phpstan-import-type BetaServerToolCallerShape from \Anthropic\Beta\Messages\BetaServerToolCaller
 * @phpstan-import-type BetaServerToolCaller20260120Shape from \Anthropic\Beta\Messages\BetaServerToolCaller20260120
 *
 * @phpstan-type BetaToolUseCallerVariants = BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120
 * @phpstan-type BetaToolUseCallerShape = BetaToolUseCallerVariants|BetaDirectCallerShape|BetaServerToolCallerShape|BetaServerToolCaller20260120Shape
 */
final class BetaToolUseCaller implements ConverterSource
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
