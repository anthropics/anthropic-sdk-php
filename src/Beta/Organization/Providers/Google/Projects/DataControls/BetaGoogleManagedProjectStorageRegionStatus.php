<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaGoogleManagedProjectStorageRegionNotConfiguredShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageRegionNotConfigured
 * @phpstan-import-type BetaGoogleManagedProjectStorageRegionPendingShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageRegionPending
 * @phpstan-import-type BetaGoogleManagedProjectStorageRegionActiveShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageRegionActive
 * @phpstan-import-type BetaGoogleManagedProjectStorageRegionFailedShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageRegionFailed
 * @phpstan-import-type BetaGoogleManagedProjectStorageRegionSuspendedShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageRegionSuspended
 *
 * @phpstan-type BetaGoogleManagedProjectStorageRegionStatusVariants = BetaGoogleManagedProjectStorageRegionNotConfigured|BetaGoogleManagedProjectStorageRegionPending|BetaGoogleManagedProjectStorageRegionActive|BetaGoogleManagedProjectStorageRegionFailed|BetaGoogleManagedProjectStorageRegionSuspended
 * @phpstan-type BetaGoogleManagedProjectStorageRegionStatusShape = BetaGoogleManagedProjectStorageRegionStatusVariants|BetaGoogleManagedProjectStorageRegionNotConfiguredShape|BetaGoogleManagedProjectStorageRegionPendingShape|BetaGoogleManagedProjectStorageRegionActiveShape|BetaGoogleManagedProjectStorageRegionFailedShape|BetaGoogleManagedProjectStorageRegionSuspendedShape
 */
final class BetaGoogleManagedProjectStorageRegionStatus implements ConverterSource
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
            'not_configured' => BetaGoogleManagedProjectStorageRegionNotConfigured::class,
            'pending' => BetaGoogleManagedProjectStorageRegionPending::class,
            'active' => BetaGoogleManagedProjectStorageRegionActive::class,
            'failed' => BetaGoogleManagedProjectStorageRegionFailed::class,
            'suspended' => BetaGoogleManagedProjectStorageRegionSuspended::class,
        ];
    }
}
