<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKControlParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * How to set the `cmek` control, discriminated by `type`.
 *
 * @phpstan-import-type BetaGoogleManagedCMEKDisabledParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKDisabledParams
 * @phpstan-import-type BetaGoogleManagedCMEKEnabledParamsShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKEnabledParams
 *
 * @phpstan-type BetaGoogleManagedCMEKControlParamsVariants = BetaGoogleManagedCMEKDisabledParams|BetaGoogleManagedCMEKEnabledParams
 * @phpstan-type BetaGoogleManagedCMEKControlParamsShape = BetaGoogleManagedCMEKControlParamsVariants|BetaGoogleManagedCMEKDisabledParamsShape|BetaGoogleManagedCMEKEnabledParamsShape
 */
final class BetaGoogleManagedCMEKControlParams implements ConverterSource
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
            'disabled' => BetaGoogleManagedCMEKDisabledParams::class,
            'enabled' => BetaGoogleManagedCMEKEnabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param array<string,string|null>|null $externalKeyIDs
     *
     * @return ($type is Type::DISABLED|'disabled' ? BetaGoogleManagedCMEKDisabledParams : ($type is Type::ENABLED|'enabled' ? BetaGoogleManagedCMEKEnabledParams : BetaGoogleManagedCMEKDisabledParams|BetaGoogleManagedCMEKEnabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $externalKeyIDs = null
    ): BetaGoogleManagedCMEKDisabledParams|BetaGoogleManagedCMEKEnabledParams {
        return match ($type) {
            Type::DISABLED, 'disabled' => BetaGoogleManagedCMEKDisabledParams::with(
            ),
            Type::ENABLED, 'enabled' => BetaGoogleManagedCMEKEnabledParams::with(
                externalKeyIDs: $externalKeyIDs
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
