<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The customer-owned storage control, discriminated by `type`.
 *
 * @phpstan-import-type BetaGoogleManagedStorageDisabledShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageDisabled
 * @phpstan-import-type BetaGoogleManagedStorageEnabledShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageEnabled
 *
 * @phpstan-type BetaGoogleManagedStorageControlVariants = BetaGoogleManagedStorageDisabled|BetaGoogleManagedStorageEnabled
 * @phpstan-type BetaGoogleManagedStorageControlShape = BetaGoogleManagedStorageControlVariants|BetaGoogleManagedStorageDisabledShape|BetaGoogleManagedStorageEnabledShape
 */
final class BetaGoogleManagedStorageControl implements ConverterSource
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
            'disabled' => BetaGoogleManagedStorageDisabled::class,
            'enabled' => BetaGoogleManagedStorageEnabled::class,
        ];
    }
}
