<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which tools' results contribute URLs that may be fetched. Accepts the string "all" or "none", or an object whose type is "all", "none", "only" or "except". Responses use the object form.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolFilterShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolFilter
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceToolFilterParamsVariants = BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept|value-of<BetaManagedAgentsWebFetchURLSourceShorthand>
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceToolFilterParamsShape = BetaManagedAgentsWebFetchURLSourceToolFilterParamsVariants|BetaManagedAgentsWebFetchURLSourceToolFilterShape
 */
final class BetaManagedAgentsWebFetchURLSourceToolFilterParams implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaManagedAgentsWebFetchURLSourceShorthand::class,
            BetaManagedAgentsWebFetchURLSourceToolFilter::class,
        ];
    }
}
