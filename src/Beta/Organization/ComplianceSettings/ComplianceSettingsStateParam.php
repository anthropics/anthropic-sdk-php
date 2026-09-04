<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ComplianceSettingsStateEnabledParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabledParam
 * @phpstan-import-type ComplianceSettingsStateDisabledParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabledParam
 *
 * @phpstan-type ComplianceSettingsStateParamVariants = ComplianceSettingsStateEnabledParam|ComplianceSettingsStateDisabledParam
 * @phpstan-type ComplianceSettingsStateParamShape = ComplianceSettingsStateParamVariants|ComplianceSettingsStateEnabledParamShape|ComplianceSettingsStateDisabledParamShape
 */
final class ComplianceSettingsStateParam implements ConverterSource
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
            'enabled' => ComplianceSettingsStateEnabledParam::class,
            'disabled' => ComplianceSettingsStateDisabledParam::class,
        ];
    }
}
