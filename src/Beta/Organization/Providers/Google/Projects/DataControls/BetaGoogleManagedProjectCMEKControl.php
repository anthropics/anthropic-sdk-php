<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The customer-managed encryption key control: the key in your Google Cloud KMS that is set for each region. It covers the project's requests that name no user profile, or a user profile that has no key of its own for the project.
 *
 * @phpstan-import-type BetaGoogleManagedProjectCMEKDisabledShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKDisabled
 * @phpstan-import-type BetaGoogleManagedProjectCMEKEnabledShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectCMEKEnabled
 *
 * @phpstan-type BetaGoogleManagedProjectCMEKControlVariants = BetaGoogleManagedProjectCMEKDisabled|BetaGoogleManagedProjectCMEKEnabled
 * @phpstan-type BetaGoogleManagedProjectCMEKControlShape = BetaGoogleManagedProjectCMEKControlVariants|BetaGoogleManagedProjectCMEKDisabledShape|BetaGoogleManagedProjectCMEKEnabledShape
 */
final class BetaGoogleManagedProjectCMEKControl implements ConverterSource
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
            'disabled' => BetaGoogleManagedProjectCMEKDisabled::class,
            'enabled' => BetaGoogleManagedProjectCMEKEnabled::class,
        ];
    }
}
