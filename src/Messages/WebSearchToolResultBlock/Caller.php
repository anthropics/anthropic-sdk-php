<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebSearchToolResultBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\DirectCaller;
use Anthropic\Messages\ServerToolCaller;
use Anthropic\Messages\WebSearchToolResultBlock\Caller\ServerToolCaller20260120;

/**
 * Tool invocation directly from the model.
 *
 * @phpstan-import-type DirectCallerShape from \Anthropic\Messages\DirectCaller
 * @phpstan-import-type ServerToolCallerShape from \Anthropic\Messages\ServerToolCaller
 * @phpstan-import-type ServerToolCaller20260120Shape from \Anthropic\Messages\WebSearchToolResultBlock\Caller\ServerToolCaller20260120
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
}
