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
use Anthropic\Messages\WebFetchURLSources\ServerToolResults\Type;
use Anthropic\Messages\WebFetchURLSourceToolReference;

/**
 * Which server tools' results contribute fetchable URLs: "all", "none", or an only or except list of server tool names from tools[]; only web_search and web_fetch results ever contribute.
 *
 * @phpstan-import-type WebFetchURLSourceAllShape from \Anthropic\Messages\WebFetchURLSourceAll
 * @phpstan-import-type WebFetchURLSourceNoneShape from \Anthropic\Messages\WebFetchURLSourceNone
 * @phpstan-import-type WebFetchURLSourceOnlyShape from \Anthropic\Messages\WebFetchURLSourceOnly
 * @phpstan-import-type WebFetchURLSourceExceptShape from \Anthropic\Messages\WebFetchURLSourceExcept
 * @phpstan-import-type WebFetchURLSourceToolReferenceShape from \Anthropic\Messages\WebFetchURLSourceToolReference
 *
 * @phpstan-type ServerToolResultsVariants = WebFetchURLSourceAll|WebFetchURLSourceNone|WebFetchURLSourceOnly|WebFetchURLSourceExcept
 * @phpstan-type ServerToolResultsShape = ServerToolResultsVariants|WebFetchURLSourceAllShape|WebFetchURLSourceNoneShape|WebFetchURLSourceOnlyShape|WebFetchURLSourceExceptShape
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
            'all' => WebFetchURLSourceAll::class,
            'none' => WebFetchURLSourceNone::class,
            'only' => WebFetchURLSourceOnly::class,
            'except' => WebFetchURLSourceExcept::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<WebFetchURLSourceToolReference|WebFetchURLSourceToolReferenceShape>|null $tools
     *
     * @return ($type is Type::ALL|'all' ? WebFetchURLSourceAll : ($type is Type::NONE|'none' ? WebFetchURLSourceNone : ($type is Type::ONLY|'only' ? WebFetchURLSourceOnly : ($type is Type::EXCEPT|'except' ? WebFetchURLSourceExcept : WebFetchURLSourceAll|WebFetchURLSourceNone|WebFetchURLSourceOnly|WebFetchURLSourceExcept))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $tools = null
    ): WebFetchURLSourceAll|WebFetchURLSourceNone|WebFetchURLSourceOnly|WebFetchURLSourceExcept {
        return match ($type) {
            Type::ALL, 'all' => WebFetchURLSourceAll::with(),
            Type::NONE, 'none' => WebFetchURLSourceNone::with(),
            Type::ONLY, 'only' => WebFetchURLSourceOnly::with(
                tools: $tools ?? throw new \ArgumentCountError('$tools is required')
            ),
            Type::EXCEPT, 'except' => WebFetchURLSourceExcept::with(
                tools: $tools ?? throw new \ArgumentCountError('$tools is required')
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
