<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Messages\BatchCreateParam\Request\Params;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\TextBlockParam;

/**
 * System prompt.
 *
 * A system prompt is a way of providing context and instructions to Claude, such as specifying a particular goal or role. See our [guide to system prompts](https://docs.anthropic.com/en/docs/system-prompts).
 *
 * @phpstan-type system_alias = string|list<TextBlockParam>
 */
final class System implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(TextBlockParam::class)];
    }
}
