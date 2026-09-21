<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolUseBlock;

use Anthropic\Beta\Messages\BetaDirectCaller;
use Anthropic\Beta\Messages\BetaServerToolCaller;
use Anthropic\Beta\Messages\BetaServerToolCaller20260120;
use Anthropic\Beta\Messages\BetaToolUseBlock\Caller\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::DIRECT|'direct' ? BetaDirectCaller : ($type is Type::CODE_EXECUTION_20250825|'code_execution_20250825' ? BetaServerToolCaller : ($type is Type::CODE_EXECUTION_20260120|'code_execution_20260120' ? BetaServerToolCaller20260120 : BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $toolID = null
    ): BetaDirectCaller|BetaServerToolCaller|BetaServerToolCaller20260120 {
        return match ($type) {
            Type::DIRECT, 'direct' => BetaDirectCaller::with(),
            Type::CODE_EXECUTION_20250825, 'code_execution_20250825' => BetaServerToolCaller::with(
                toolID: $toolID ?? throw new \ArgumentCountError('$toolID is required'),
            ),
            Type::CODE_EXECUTION_20260120, 'code_execution_20260120' => BetaServerToolCaller20260120::with(
                toolID: $toolID ?? throw new \ArgumentCountError('$toolID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
