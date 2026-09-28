<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Plugin;

use Anthropic\Beta\Organization\Plugins\PluginAPIActor;
use Anthropic\Beta\Organization\Plugins\PluginUserActor;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Who created the Plugin; null when no creator is recorded.
 *
 * @phpstan-import-type PluginUserActorShape from \Anthropic\Beta\Organization\Plugins\PluginUserActor
 * @phpstan-import-type PluginAPIActorShape from \Anthropic\Beta\Organization\Plugins\PluginAPIActor
 *
 * @phpstan-type CreatedByVariants = PluginUserActor|PluginAPIActor
 * @phpstan-type CreatedByShape = CreatedByVariants|PluginUserActorShape|PluginAPIActorShape
 */
final class CreatedBy implements ConverterSource
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
            'user_actor' => PluginUserActor::class,
            'api_actor' => PluginAPIActor::class,
        ];
    }
}
