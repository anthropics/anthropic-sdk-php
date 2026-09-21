<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebFetchToolResultBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\DirectCaller;
use Anthropic\Messages\ServerToolCaller;
use Anthropic\Messages\ServerToolCaller20260120;
use Anthropic\Messages\WebFetchToolResultBlockParam\Caller\Type;

/**
 * @phpstan-import-type DirectCallerShape from \Anthropic\Messages\DirectCaller
 * @phpstan-import-type ServerToolCallerShape from \Anthropic\Messages\ServerToolCaller
 * @phpstan-import-type ServerToolCaller20260120Shape from \Anthropic\Messages\ServerToolCaller20260120
 *
 * @phpstan-type CallerVariants = DirectCaller|ServerToolCaller|ServerToolCaller20260120
 * @phpstan-type CallerShape = CallerVariants|DirectCallerShape|ServerToolCallerShape|ServerToolCaller20260120Shape
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
            'direct' => DirectCaller::class,
            'code_execution_20250825' => ServerToolCaller::class,
            'code_execution_20260120' => ServerToolCaller20260120::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::DIRECT|'direct' ? DirectCaller : ($type is Type::CODE_EXECUTION_20250825|'code_execution_20250825' ? ServerToolCaller : ($type is Type::CODE_EXECUTION_20260120|'code_execution_20260120' ? ServerToolCaller20260120 : DirectCaller|ServerToolCaller|ServerToolCaller20260120)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $toolID = null
    ): DirectCaller|ServerToolCaller|ServerToolCaller20260120 {
        return match ($type) {
            Type::DIRECT, 'direct' => DirectCaller::with(),
            Type::CODE_EXECUTION_20250825, 'code_execution_20250825' => ServerToolCaller::with(
                toolID: $toolID ?? throw new \ArgumentCountError('$toolID is required'),
            ),
            Type::CODE_EXECUTION_20260120, 'code_execution_20260120' => ServerToolCaller20260120::with(
                toolID: $toolID ?? throw new \ArgumentCountError('$toolID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
