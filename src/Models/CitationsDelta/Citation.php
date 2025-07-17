<?php

declare(strict_types=1);

namespace Anthropic\Models\CitationsDelta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Models\CitationCharLocation;
use Anthropic\Models\CitationContentBlockLocation;
use Anthropic\Models\CitationPageLocation;
use Anthropic\Models\CitationsWebSearchResultLocation;

final class Citation implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return [
            'char_location' => CitationCharLocation::class,
            'page_location' => CitationPageLocation::class,
            'content_block_location' => CitationContentBlockLocation::class,
            'web_search_result_location' => CitationsWebSearchResultLocation::class,
        ];
    }
}
