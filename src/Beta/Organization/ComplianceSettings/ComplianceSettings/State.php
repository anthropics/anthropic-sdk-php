<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabled;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabled;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the Compliance API is enabled for this organization.
 *
 * @phpstan-import-type ComplianceSettingsStateEnabledShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabled
 * @phpstan-import-type ComplianceSettingsStateDisabledShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabled
 *
 * @phpstan-type StateVariants = ComplianceSettingsStateEnabled|ComplianceSettingsStateDisabled
 * @phpstan-type StateShape = StateVariants|ComplianceSettingsStateEnabledShape|ComplianceSettingsStateDisabledShape
 */
final class State implements ConverterSource
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
