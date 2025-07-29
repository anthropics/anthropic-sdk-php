<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaContentBlockSource;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Beta\BetaContentBlockSourceContent;
use Anthropic\Models\Beta\BetaImageBlockParam;
use Anthropic\Models\Beta\BetaTextBlockParam;

/**
 * @phpstan-type content_alias = string|list<BetaTextBlockParam|BetaImageBlockParam>
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
        return ['string', new ListOf(BetaContentBlockSourceContent::class)];
    }
}
