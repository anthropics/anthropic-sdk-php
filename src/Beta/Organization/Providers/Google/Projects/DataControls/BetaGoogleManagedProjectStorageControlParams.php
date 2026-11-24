<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageControlParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The customer-owned storage control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
 *
 * @phpstan-import-type BetaGoogleManagedProjectStorageDisabledParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageDisabledParams
 * @phpstan-import-type BetaGoogleManagedProjectStorageEnabledParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageEnabledParams
 * @phpstan-import-type BetaGoogleManagedProjectBucketReferenceShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectBucketReference
 *
 * @phpstan-type BetaGoogleManagedProjectStorageControlParamsVariants = BetaGoogleManagedProjectStorageDisabledParams|BetaGoogleManagedProjectStorageEnabledParams
 * @phpstan-type BetaGoogleManagedProjectStorageControlParamsShape = BetaGoogleManagedProjectStorageControlParamsVariants|BetaGoogleManagedProjectStorageDisabledParamsShape|BetaGoogleManagedProjectStorageEnabledParamsShape
 */
final class BetaGoogleManagedProjectStorageControlParams implements ConverterSource
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
            'disabled' => BetaGoogleManagedProjectStorageDisabledParams::class,
            'enabled' => BetaGoogleManagedProjectStorageEnabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param array<string,BetaGoogleManagedProjectBucketReference|BetaGoogleManagedProjectBucketReferenceShape|null>|null $buckets
     *
     * @return ($type is Type::DISABLED|'disabled' ? BetaGoogleManagedProjectStorageDisabledParams : ($type is Type::ENABLED|'enabled' ? BetaGoogleManagedProjectStorageEnabledParams : BetaGoogleManagedProjectStorageDisabledParams|BetaGoogleManagedProjectStorageEnabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $buckets = null
    ): BetaGoogleManagedProjectStorageDisabledParams|BetaGoogleManagedProjectStorageEnabledParams {
        return match ($type) {
            Type::DISABLED, 'disabled' => BetaGoogleManagedProjectStorageDisabledParams::with(
            ),
            Type::ENABLED, 'enabled' => BetaGoogleManagedProjectStorageEnabledParams::with(
                buckets: $buckets
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
