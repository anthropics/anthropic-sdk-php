<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebFetchURLSources;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\WebFetchURLSourceAll;
use Anthropic\Messages\WebFetchURLSourceNone;
use Anthropic\Messages\WebFetchURLSources\UserInput\Type;

/**
 * Whether URLs in user messages are fetchable: "all" or "none".
 *
 * @phpstan-import-type WebFetchURLSourceAllShape from \Anthropic\Messages\WebFetchURLSourceAll
 * @phpstan-import-type WebFetchURLSourceNoneShape from \Anthropic\Messages\WebFetchURLSourceNone
 *
 * @phpstan-type UserInputVariants = WebFetchURLSourceAll|WebFetchURLSourceNone
 * @phpstan-type UserInputShape = UserInputVariants|WebFetchURLSourceAllShape|WebFetchURLSourceNoneShape
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
            'all' => WebFetchURLSourceAll::class,
            'none' => WebFetchURLSourceNone::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ALL|'all' ? WebFetchURLSourceAll : ($type is Type::NONE|'none' ? WebFetchURLSourceNone : WebFetchURLSourceAll|WebFetchURLSourceNone))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): WebFetchURLSourceAll|WebFetchURLSourceNone {
        return match ($type) {
            Type::ALL, 'all' => WebFetchURLSourceAll::with(),
            Type::NONE, 'none' => WebFetchURLSourceNone::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
