<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;

use Anthropic\Beta\Organization\Plugins\PluginOwnerOrganization;
use Anthropic\Beta\Organization\Plugins\PluginOwnerUser;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The organization, or the member whose personal plugin marketplace it is.
 *
 * @phpstan-import-type PluginOwnerOrganizationShape from \Anthropic\Beta\Organization\Plugins\PluginOwnerOrganization
 * @phpstan-import-type PluginOwnerUserShape from \Anthropic\Beta\Organization\Plugins\PluginOwnerUser
 *
 * @phpstan-type OwnerVariants = PluginOwnerOrganization|PluginOwnerUser
 * @phpstan-type OwnerShape = OwnerVariants|PluginOwnerOrganizationShape|PluginOwnerUserShape
 */
final class Owner implements ConverterSource
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
            'organization' => PluginOwnerOrganization::class,
            'user' => PluginOwnerUser::class,
        ];
    }
}
