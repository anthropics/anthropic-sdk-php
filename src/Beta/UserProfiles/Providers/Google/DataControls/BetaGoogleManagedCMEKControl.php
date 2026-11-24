<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The customer-managed encryption key control, discriminated by `type`.
 *
 * @phpstan-import-type BetaGoogleManagedCMEKDisabledShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKDisabled
 * @phpstan-import-type BetaGoogleManagedCMEKEnabledShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedCMEKEnabled
 *
 * @phpstan-type BetaGoogleManagedCMEKControlVariants = BetaGoogleManagedCMEKDisabled|BetaGoogleManagedCMEKEnabled
 * @phpstan-type BetaGoogleManagedCMEKControlShape = BetaGoogleManagedCMEKControlVariants|BetaGoogleManagedCMEKDisabledShape|BetaGoogleManagedCMEKEnabledShape
 */
final class BetaGoogleManagedCMEKControl implements ConverterSource
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
            'disabled' => BetaGoogleManagedCMEKDisabled::class,
            'enabled' => BetaGoogleManagedCMEKEnabled::class,
        ];
    }
}
