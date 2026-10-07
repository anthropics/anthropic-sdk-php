<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which party invoked the tool call: the model directly, or a server tool on its behalf.
 *
 * @phpstan-import-type DirectCallerShape from \Anthropic\Messages\DirectCaller
 * @phpstan-import-type ServerToolCallerShape from \Anthropic\Messages\ServerToolCaller
 * @phpstan-import-type ServerToolCaller20260120Shape from \Anthropic\Messages\ServerToolCaller20260120
 *
 * @phpstan-type ToolUseCallerVariants = DirectCaller|ServerToolCaller|ServerToolCaller20260120
 * @phpstan-type ToolUseCallerShape = ToolUseCallerVariants|DirectCallerShape|ServerToolCallerShape|ServerToolCaller20260120Shape
 */
final class ToolUseCaller implements ConverterSource
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
}
