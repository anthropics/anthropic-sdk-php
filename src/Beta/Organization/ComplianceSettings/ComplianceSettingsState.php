<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ComplianceSettingsStateEnabledShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabled
 * @phpstan-import-type ComplianceSettingsStateDisabledShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabled
 *
 * @phpstan-type ComplianceSettingsStateVariants = ComplianceSettingsStateEnabled|ComplianceSettingsStateDisabled
 * @phpstan-type ComplianceSettingsStateShape = ComplianceSettingsStateVariants|ComplianceSettingsStateEnabledShape|ComplianceSettingsStateDisabledShape
 */
final class ComplianceSettingsState implements ConverterSource
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
            'enabled' => ComplianceSettingsStateEnabled::class,
            'disabled' => ComplianceSettingsStateDisabled::class,
        ];
    }
}
