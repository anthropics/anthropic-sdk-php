<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolFilter\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Which tools' results contribute URLs that may be fetched.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceAllShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceAll
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceNoneShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceNone
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceOnlyShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceOnly
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceExceptShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceExcept
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceToolReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceToolReference
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceToolFilterVariants = BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceToolFilterShape = BetaManagedAgentsWebFetchURLSourceToolFilterVariants|BetaManagedAgentsWebFetchURLSourceAllShape|BetaManagedAgentsWebFetchURLSourceNoneShape|BetaManagedAgentsWebFetchURLSourceOnlyShape|BetaManagedAgentsWebFetchURLSourceExceptShape
 */
final class BetaManagedAgentsWebFetchURLSourceToolFilter implements ConverterSource
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
            'all' => BetaManagedAgentsWebFetchURLSourceAll::class,
            'none' => BetaManagedAgentsWebFetchURLSourceNone::class,
            'only' => BetaManagedAgentsWebFetchURLSourceOnly::class,
            'except' => BetaManagedAgentsWebFetchURLSourceExcept::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<BetaManagedAgentsWebFetchURLSourceToolReference|BetaManagedAgentsWebFetchURLSourceToolReferenceShape>|null $tools
     *
     * @return ($type is Type::ALL|'all' ? BetaManagedAgentsWebFetchURLSourceAll : ($type is Type::NONE|'none' ? BetaManagedAgentsWebFetchURLSourceNone : ($type is Type::ONLY|'only' ? BetaManagedAgentsWebFetchURLSourceOnly : ($type is Type::EXCEPT|'except' ? BetaManagedAgentsWebFetchURLSourceExcept : BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $tools = null
    ): BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone|BetaManagedAgentsWebFetchURLSourceOnly|BetaManagedAgentsWebFetchURLSourceExcept {
        return match ($type) {
            Type::ALL, 'all' => BetaManagedAgentsWebFetchURLSourceAll::with(),
            Type::NONE, 'none' => BetaManagedAgentsWebFetchURLSourceNone::with(),
            Type::ONLY, 'only' => BetaManagedAgentsWebFetchURLSourceOnly::with(
                tools: $tools ?? throw new \ArgumentCountError('$tools is required')
            ),
            Type::EXCEPT, 'except' => BetaManagedAgentsWebFetchURLSourceExcept::with(
                tools: $tools ?? throw new \ArgumentCountError('$tools is required')
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
