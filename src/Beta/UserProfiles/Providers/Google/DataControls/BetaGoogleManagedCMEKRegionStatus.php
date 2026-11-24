<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * One region's status for the `cmek` control, discriminated by `type`.
 *
 * @phpstan-import-type BetaGoogleManagedCMEKRegionNotConfiguredShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionNotConfigured
 * @phpstan-import-type BetaGoogleManagedCMEKRegionPendingShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionPending
 * @phpstan-import-type BetaGoogleManagedCMEKRegionActiveShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionActive
 * @phpstan-import-type BetaGoogleManagedCMEKRegionFailedShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionFailed
 * @phpstan-import-type BetaGoogleManagedCMEKRegionSuspendedShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKRegionSuspended
 *
 * @phpstan-type BetaGoogleManagedCMEKRegionStatusVariants = BetaGoogleManagedCMEKRegionNotConfigured|BetaGoogleManagedCMEKRegionPending|BetaGoogleManagedCMEKRegionActive|BetaGoogleManagedCMEKRegionFailed|BetaGoogleManagedCMEKRegionSuspended
 * @phpstan-type BetaGoogleManagedCMEKRegionStatusShape = BetaGoogleManagedCMEKRegionStatusVariants|BetaGoogleManagedCMEKRegionNotConfiguredShape|BetaGoogleManagedCMEKRegionPendingShape|BetaGoogleManagedCMEKRegionActiveShape|BetaGoogleManagedCMEKRegionFailedShape|BetaGoogleManagedCMEKRegionSuspendedShape
 */
final class BetaGoogleManagedCMEKRegionStatus implements ConverterSource
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
            'not_configured' => BetaGoogleManagedCMEKRegionNotConfigured::class,
            'pending' => BetaGoogleManagedCMEKRegionPending::class,
            'active' => BetaGoogleManagedCMEKRegionActive::class,
            'failed' => BetaGoogleManagedCMEKRegionFailed::class,
            'suspended' => BetaGoogleManagedCMEKRegionSuspended::class,
        ];
    }
}
