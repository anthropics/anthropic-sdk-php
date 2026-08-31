<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingUpdateParams;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabledParam;
use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabledParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Desired state. Accepts the string shorthand "enabled" or "disabled" in place of the object form; the response always returns the canonical object form.
 *
 * @phpstan-import-type ComplianceSettingsStateEnabledParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateEnabledParam
 * @phpstan-import-type ComplianceSettingsStateDisabledParamShape from \Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateDisabledParam
 *
 * @phpstan-type StateVariants = ComplianceSettingsStateEnabledParam|ComplianceSettingsStateDisabledParam
 * @phpstan-type StateShape = StateVariants|ComplianceSettingsStateEnabledParamShape|ComplianceSettingsStateDisabledParamShape
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
            'enabled' => ComplianceSettingsStateEnabledParam::class,
            'disabled' => ComplianceSettingsStateDisabledParam::class,
        ];
    }
}
