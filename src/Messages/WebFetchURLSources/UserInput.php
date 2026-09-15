<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebFetchURLSources;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\WebFetchURLSourceAll;
use Anthropic\Messages\WebFetchURLSourceNone;

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
}
