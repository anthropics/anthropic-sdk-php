<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * One region's status for the `storage` control, discriminated by `type`.
 *
 * @phpstan-import-type BetaGoogleManagedStorageRegionNotConfiguredShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageRegionNotConfigured
 * @phpstan-import-type BetaGoogleManagedStorageRegionPendingShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageRegionPending
 * @phpstan-import-type BetaGoogleManagedStorageRegionActiveShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageRegionActive
 * @phpstan-import-type BetaGoogleManagedStorageRegionFailedShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageRegionFailed
 * @phpstan-import-type BetaGoogleManagedStorageRegionSuspendedShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageRegionSuspended
 *
 * @phpstan-type BetaGoogleManagedStorageRegionStatusVariants = BetaGoogleManagedStorageRegionNotConfigured|BetaGoogleManagedStorageRegionPending|BetaGoogleManagedStorageRegionActive|BetaGoogleManagedStorageRegionFailed|BetaGoogleManagedStorageRegionSuspended
 * @phpstan-type BetaGoogleManagedStorageRegionStatusShape = BetaGoogleManagedStorageRegionStatusVariants|BetaGoogleManagedStorageRegionNotConfiguredShape|BetaGoogleManagedStorageRegionPendingShape|BetaGoogleManagedStorageRegionActiveShape|BetaGoogleManagedStorageRegionFailedShape|BetaGoogleManagedStorageRegionSuspendedShape
 */
final class BetaGoogleManagedStorageRegionStatus implements ConverterSource
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
            'not_configured' => BetaGoogleManagedStorageRegionNotConfigured::class,
            'pending' => BetaGoogleManagedStorageRegionPending::class,
            'active' => BetaGoogleManagedStorageRegionActive::class,
            'failed' => BetaGoogleManagedStorageRegionFailed::class,
            'suspended' => BetaGoogleManagedStorageRegionSuspended::class,
        ];
    }
}
