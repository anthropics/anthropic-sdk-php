<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings;

use Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingsState\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ENABLED|'enabled' ? ComplianceSettingsStateEnabled : ($type is Type::DISABLED|'disabled' ? ComplianceSettingsStateDisabled : ComplianceSettingsStateEnabled|ComplianceSettingsStateDisabled))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): ComplianceSettingsStateEnabled|ComplianceSettingsStateDisabled {
        return match ($type) {
            Type::ENABLED, 'enabled' => ComplianceSettingsStateEnabled::with(),
            Type::DISABLED, 'disabled' => ComplianceSettingsStateDisabled::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
