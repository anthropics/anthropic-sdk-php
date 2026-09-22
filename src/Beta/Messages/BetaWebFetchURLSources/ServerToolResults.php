<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchURLSources;

use Anthropic\Beta\Messages\BetaWebFetchURLSourceAll;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceExcept;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceNone;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceOnly;
use Anthropic\Beta\Messages\BetaWebFetchURLSources\ServerToolResults\Type;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceToolReference;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which server tools' results contribute fetchable URLs: "all", "none", or an only or except list of server tool names from tools[]; only web_search and web_fetch results ever contribute.
 *
 * @phpstan-import-type BetaWebFetchURLSourceAllShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceAll
 * @phpstan-import-type BetaWebFetchURLSourceNoneShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceNone
 * @phpstan-import-type BetaWebFetchURLSourceOnlyShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceOnly
 * @phpstan-import-type BetaWebFetchURLSourceExceptShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceExcept
 * @phpstan-import-type BetaWebFetchURLSourceToolReferenceShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceToolReference
 *
 * @phpstan-type ServerToolResultsVariants = BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept
 * @phpstan-type ServerToolResultsShape = ServerToolResultsVariants|BetaWebFetchURLSourceAllShape|BetaWebFetchURLSourceNoneShape|BetaWebFetchURLSourceOnlyShape|BetaWebFetchURLSourceExceptShape
 */
final class ServerToolResults implements ConverterSource
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<BetaWebFetchURLSourceToolReference|BetaWebFetchURLSourceToolReferenceShape>|null $tools
     *
     * @return ($type is Type::ALL|'all' ? BetaWebFetchURLSourceAll : ($type is Type::NONE|'none' ? BetaWebFetchURLSourceNone : ($type is Type::ONLY|'only' ? BetaWebFetchURLSourceOnly : ($type is Type::EXCEPT|'except' ? BetaWebFetchURLSourceExcept : BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $tools = null
    ): BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone|BetaWebFetchURLSourceOnly|BetaWebFetchURLSourceExcept {
        return match ($type) {
            Type::ALL, 'all' => BetaWebFetchURLSourceAll::with(),
            Type::NONE, 'none' => BetaWebFetchURLSourceNone::with(),
            Type::ONLY, 'only' => BetaWebFetchURLSourceOnly::with(
                tools: $tools ?? throw new \ArgumentCountError('$tools is required')
            ),
            Type::EXCEPT, 'except' => BetaWebFetchURLSourceExcept::with(
                tools: $tools ?? throw new \ArgumentCountError('$tools is required')
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
