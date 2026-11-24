<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaGoogleManagedProjectCMEKRegionNotConfiguredShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKRegionNotConfigured
 * @phpstan-import-type BetaGoogleManagedProjectCMEKRegionPendingShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKRegionPending
 * @phpstan-import-type BetaGoogleManagedProjectCMEKRegionActiveShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKRegionActive
 * @phpstan-import-type BetaGoogleManagedProjectCMEKRegionFailedShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKRegionFailed
 * @phpstan-import-type BetaGoogleManagedProjectCMEKRegionSuspendedShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKRegionSuspended
 *
 * @phpstan-type BetaGoogleManagedProjectCMEKRegionStatusVariants = BetaGoogleManagedProjectCMEKRegionNotConfigured|BetaGoogleManagedProjectCMEKRegionPending|BetaGoogleManagedProjectCMEKRegionActive|BetaGoogleManagedProjectCMEKRegionFailed|BetaGoogleManagedProjectCMEKRegionSuspended
 * @phpstan-type BetaGoogleManagedProjectCMEKRegionStatusShape = BetaGoogleManagedProjectCMEKRegionStatusVariants|BetaGoogleManagedProjectCMEKRegionNotConfiguredShape|BetaGoogleManagedProjectCMEKRegionPendingShape|BetaGoogleManagedProjectCMEKRegionActiveShape|BetaGoogleManagedProjectCMEKRegionFailedShape|BetaGoogleManagedProjectCMEKRegionSuspendedShape
 */
final class BetaGoogleManagedProjectCMEKRegionStatus implements ConverterSource
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
            'not_configured' => BetaGoogleManagedProjectCMEKRegionNotConfigured::class,
            'pending' => BetaGoogleManagedProjectCMEKRegionPending::class,
            'active' => BetaGoogleManagedProjectCMEKRegionActive::class,
            'failed' => BetaGoogleManagedProjectCMEKRegionFailed::class,
            'suspended' => BetaGoogleManagedProjectCMEKRegionSuspended::class,
        ];
    }
}
