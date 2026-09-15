<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebFetchURLSources;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\WebFetchURLSourceAll;
use Anthropic\Messages\WebFetchURLSourceExcept;
use Anthropic\Messages\WebFetchURLSourceNone;
use Anthropic\Messages\WebFetchURLSourceOnly;

/**
 * Which client tools' results contribute fetchable URLs: "all", "none", or an only or except list of client tool names from tools[].
 *
 * @phpstan-import-type WebFetchURLSourceAllShape from \Anthropic\Messages\WebFetchURLSourceAll
 * @phpstan-import-type WebFetchURLSourceNoneShape from \Anthropic\Messages\WebFetchURLSourceNone
 * @phpstan-import-type WebFetchURLSourceOnlyShape from \Anthropic\Messages\WebFetchURLSourceOnly
 * @phpstan-import-type WebFetchURLSourceExceptShape from \Anthropic\Messages\WebFetchURLSourceExcept
 *
 * @phpstan-type ClientToolResultsVariants = WebFetchURLSourceAll|WebFetchURLSourceNone|WebFetchURLSourceOnly|WebFetchURLSourceExcept
 * @phpstan-type ClientToolResultsShape = ClientToolResultsVariants|WebFetchURLSourceAllShape|WebFetchURLSourceNoneShape|WebFetchURLSourceOnlyShape|WebFetchURLSourceExceptShape
 */
final class ClientToolResults implements ConverterSource
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
            'all' => WebFetchURLSourceAll::class,
            'none' => WebFetchURLSourceNone::class,
            'only' => WebFetchURLSourceOnly::class,
            'except' => WebFetchURLSourceExcept::class,
        ];
    }
}
