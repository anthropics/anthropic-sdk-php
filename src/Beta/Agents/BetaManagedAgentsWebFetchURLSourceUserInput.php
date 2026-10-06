<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceUserInput\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether URLs in the text of user messages may be fetched.
 *
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceAllShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceAll
 * @phpstan-import-type BetaManagedAgentsWebFetchURLSourceNoneShape from \Anthropic\Beta\Agents\BetaManagedAgentsWebFetchURLSourceNone
 *
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceUserInputVariants = BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone
 * @phpstan-type BetaManagedAgentsWebFetchURLSourceUserInputShape = BetaManagedAgentsWebFetchURLSourceUserInputVariants|BetaManagedAgentsWebFetchURLSourceAllShape|BetaManagedAgentsWebFetchURLSourceNoneShape
 */
final class BetaManagedAgentsWebFetchURLSourceUserInput implements ConverterSource
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
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ALL|'all' ? BetaManagedAgentsWebFetchURLSourceAll : ($type is Type::NONE|'none' ? BetaManagedAgentsWebFetchURLSourceNone : BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): BetaManagedAgentsWebFetchURLSourceAll|BetaManagedAgentsWebFetchURLSourceNone {
        return match ($type) {
            Type::ALL, 'all' => BetaManagedAgentsWebFetchURLSourceAll::with(),
            Type::NONE, 'none' => BetaManagedAgentsWebFetchURLSourceNone::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
