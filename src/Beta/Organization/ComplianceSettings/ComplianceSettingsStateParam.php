<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsStateParam\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ENABLED|'enabled' ? ComplianceSettingsStateEnabledParam : ($type is Type::DISABLED|'disabled' ? ComplianceSettingsStateDisabledParam : ComplianceSettingsStateEnabledParam|ComplianceSettingsStateDisabledParam))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): ComplianceSettingsStateEnabledParam|ComplianceSettingsStateDisabledParam {
        return match ($type) {
            Type::ENABLED, 'enabled' => ComplianceSettingsStateEnabledParam::with(),
            Type::DISABLED, 'disabled' => ComplianceSettingsStateDisabledParam::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
