<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration;

use Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsModeParam\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaClaudeCodeManagedSettingsOrganizationModeParamShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsOrganizationModeParam
 * @phpstan-import-type BetaClaudeCodeManagedSettingsRBACGroupsModeParamShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsRBACGroupsModeParam
 *
 * @phpstan-type BetaClaudeCodeManagedSettingsModeParamVariants = BetaClaudeCodeManagedSettingsOrganizationModeParam|BetaClaudeCodeManagedSettingsRBACGroupsModeParam
 * @phpstan-type BetaClaudeCodeManagedSettingsModeParamShape = BetaClaudeCodeManagedSettingsModeParamVariants|BetaClaudeCodeManagedSettingsOrganizationModeParamShape|BetaClaudeCodeManagedSettingsRBACGroupsModeParamShape
 */
final class BetaClaudeCodeManagedSettingsModeParam implements ConverterSource
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
            'organization' => BetaClaudeCodeManagedSettingsOrganizationModeParam::class,
            'rbac_groups' => BetaClaudeCodeManagedSettingsRBACGroupsModeParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ORGANIZATION|'organization' ? BetaClaudeCodeManagedSettingsOrganizationModeParam : ($type is Type::RBAC_GROUPS|'rbac_groups' ? BetaClaudeCodeManagedSettingsRBACGroupsModeParam : BetaClaudeCodeManagedSettingsOrganizationModeParam|BetaClaudeCodeManagedSettingsRBACGroupsModeParam))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): BetaClaudeCodeManagedSettingsOrganizationModeParam|BetaClaudeCodeManagedSettingsRBACGroupsModeParam {
        return match ($type) {
            Type::ORGANIZATION, 'organization' => BetaClaudeCodeManagedSettingsOrganizationModeParam::with(
            ),
            Type::RBAC_GROUPS, 'rbac_groups' => BetaClaudeCodeManagedSettingsRBACGroupsModeParam::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
