<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchURLSources;

use Anthropic\Beta\Messages\BetaWebFetchURLSourceAll;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceExcept;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceNone;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceOnly;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which client tools' results contribute fetchable URLs: "all", "none", or an only or except list of client tool names from tools[].
 *
 * @phpstan-import-type BetaWebFetchURLSourceAllShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceAll
 * @phpstan-import-type BetaWebFetchURLSourceNoneShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceNone
 * @phpstan-import-type BetaWebFetchURLSourceOnlyShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceOnly
 * @phpstan-import-type BetaWebFetchURLSourceExceptShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceExcept
 *
 * @phpstan-type ClientToolResultsVariants = BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept
 * @phpstan-type ClientToolResultsShape = ClientToolResultsVariants|BetaWebFetchURLSourceAllShape|BetaWebFetchURLSourceNoneShape|BetaWebFetchURLSourceOnlyShape|BetaWebFetchURLSourceExceptShape
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
            'all' => BetaWebFetchURLSourceAll::class,
            'none' => BetaWebFetchURLSourceNone::class,
            'only' => BetaWebFetchURLSourceOnly::class,
            'except' => BetaWebFetchURLSourceExcept::class,
        ];
    }
}
