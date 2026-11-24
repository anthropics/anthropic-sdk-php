<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageControlParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How to set the `storage` control, discriminated by `type`.
 *
 * @phpstan-import-type BetaGoogleManagedStorageDisabledParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageDisabledParams
 * @phpstan-import-type BetaGoogleManagedStorageEnabledParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageEnabledParams
 * @phpstan-import-type BetaGoogleManagedBucketReferenceShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedBucketReference
 *
 * @phpstan-type BetaGoogleManagedStorageControlParamsVariants = BetaGoogleManagedStorageDisabledParams|BetaGoogleManagedStorageEnabledParams
 * @phpstan-type BetaGoogleManagedStorageControlParamsShape = BetaGoogleManagedStorageControlParamsVariants|BetaGoogleManagedStorageDisabledParamsShape|BetaGoogleManagedStorageEnabledParamsShape
 */
final class BetaGoogleManagedStorageControlParams implements ConverterSource
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
            'disabled' => BetaGoogleManagedStorageDisabledParams::class,
            'enabled' => BetaGoogleManagedStorageEnabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param array<string,BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape|null>|null $buckets
     *
     * @return ($type is Type::DISABLED|'disabled' ? BetaGoogleManagedStorageDisabledParams : ($type is Type::ENABLED|'enabled' ? BetaGoogleManagedStorageEnabledParams : BetaGoogleManagedStorageDisabledParams|BetaGoogleManagedStorageEnabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $buckets = null
    ): BetaGoogleManagedStorageDisabledParams|BetaGoogleManagedStorageEnabledParams {
        return match ($type) {
            Type::DISABLED, 'disabled' => BetaGoogleManagedStorageDisabledParams::with(
            ),
            Type::ENABLED, 'enabled' => BetaGoogleManagedStorageEnabledParams::with(
                buckets: $buckets
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
