<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The customer-owned storage control: your Cloud Storage bucket that is set for each region. It covers the project's requests that name no user profile, or a user profile that has no bucket of its own for the project.
 *
 * @phpstan-import-type BetaGoogleManagedProjectStorageDisabledShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageDisabled
 * @phpstan-import-type BetaGoogleManagedProjectStorageEnabledShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageEnabled
 *
 * @phpstan-type BetaGoogleManagedProjectStorageControlVariants = BetaGoogleManagedProjectStorageDisabled|BetaGoogleManagedProjectStorageEnabled
 * @phpstan-type BetaGoogleManagedProjectStorageControlShape = BetaGoogleManagedProjectStorageControlVariants|BetaGoogleManagedProjectStorageDisabledShape|BetaGoogleManagedProjectStorageEnabledShape
 */
final class BetaGoogleManagedProjectStorageControl implements ConverterSource
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
            'disabled' => BetaGoogleManagedProjectStorageDisabled::class,
            'enabled' => BetaGoogleManagedProjectStorageEnabled::class,
        ];
    }
}
