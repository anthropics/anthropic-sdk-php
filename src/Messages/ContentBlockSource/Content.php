<?php

declare(strict_types=1);

namespace Anthropic\Messages\ContentBlockSource;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Messages\ContentBlockSourceContent;
use Anthropic\Messages\ImageBlockParam;
use Anthropic\Messages\TextBlockParam;

/**
 * @phpstan-type content_alias = string|list<TextBlockParam|ImageBlockParam>
 */
final class Content implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return ['string', new ListOf(ContentBlockSourceContent::class)];
    }
}
