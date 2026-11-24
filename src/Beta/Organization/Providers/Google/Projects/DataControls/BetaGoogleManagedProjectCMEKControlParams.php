<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKControlParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The customer-managed encryption key control. Leave it out to keep the control as it is. Send `cmek`, `storage`, or both.
 *
 * @phpstan-import-type BetaGoogleManagedProjectCMEKDisabledParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKDisabledParams
 * @phpstan-import-type BetaGoogleManagedProjectCMEKEnabledParamsShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKEnabledParams
 *
 * @phpstan-type BetaGoogleManagedProjectCMEKControlParamsVariants = BetaGoogleManagedProjectCMEKDisabledParams|BetaGoogleManagedProjectCMEKEnabledParams
 * @phpstan-type BetaGoogleManagedProjectCMEKControlParamsShape = BetaGoogleManagedProjectCMEKControlParamsVariants|BetaGoogleManagedProjectCMEKDisabledParamsShape|BetaGoogleManagedProjectCMEKEnabledParamsShape
 */
final class BetaGoogleManagedProjectCMEKControlParams implements ConverterSource
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
            'disabled' => BetaGoogleManagedProjectCMEKDisabledParams::class,
            'enabled' => BetaGoogleManagedProjectCMEKEnabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param array<string,string|null>|null $externalKeyIDs
     *
     * @return ($type is Type::DISABLED|'disabled' ? BetaGoogleManagedProjectCMEKDisabledParams : ($type is Type::ENABLED|'enabled' ? BetaGoogleManagedProjectCMEKEnabledParams : BetaGoogleManagedProjectCMEKDisabledParams|BetaGoogleManagedProjectCMEKEnabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $externalKeyIDs = null
    ): BetaGoogleManagedProjectCMEKDisabledParams|BetaGoogleManagedProjectCMEKEnabledParams {
        return match ($type) {
            Type::DISABLED, 'disabled' => BetaGoogleManagedProjectCMEKDisabledParams::with(
            ),
            Type::ENABLED, 'enabled' => BetaGoogleManagedProjectCMEKEnabledParams::with(
                externalKeyIDs: $externalKeyIDs
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
