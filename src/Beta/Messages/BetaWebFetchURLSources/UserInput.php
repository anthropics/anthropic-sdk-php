<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchURLSources;

use Anthropic\Beta\Messages\BetaWebFetchURLSourceAll;
use Anthropic\Beta\Messages\BetaWebFetchURLSourceNone;
use Anthropic\Beta\Messages\BetaWebFetchURLSources\UserInput\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether URLs in user messages are fetchable: "all" or "none".
 *
 * @phpstan-import-type BetaWebFetchURLSourceAllShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceAll
 * @phpstan-import-type BetaWebFetchURLSourceNoneShape from \Anthropic\Beta\Messages\BetaWebFetchURLSourceNone
 *
 * @phpstan-type UserInputVariants = BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone
 * @phpstan-type UserInputShape = UserInputVariants|BetaWebFetchURLSourceAllShape|BetaWebFetchURLSourceNoneShape
 */
final class UserInput implements ConverterSource
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
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ALL|'all' ? BetaWebFetchURLSourceAll : ($type is Type::NONE|'none' ? BetaWebFetchURLSourceNone : BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): BetaWebFetchURLSourceAll|BetaWebFetchURLSourceNone {
        return match ($type) {
            Type::ALL, 'all' => BetaWebFetchURLSourceAll::with(),
            Type::NONE, 'none' => BetaWebFetchURLSourceNone::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
