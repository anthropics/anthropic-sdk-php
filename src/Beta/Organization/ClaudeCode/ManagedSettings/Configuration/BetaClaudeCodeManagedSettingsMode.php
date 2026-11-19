<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaClaudeCodeManagedSettingsOrganizationModeShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsOrganizationMode
 * @phpstan-import-type BetaClaudeCodeManagedSettingsRBACGroupsModeShape from \Anthropic\Beta\Organization\ClaudeCode\ManagedSettings\Configuration\BetaClaudeCodeManagedSettingsRBACGroupsMode
 *
 * @phpstan-type BetaClaudeCodeManagedSettingsModeVariants = BetaClaudeCodeManagedSettingsOrganizationMode|BetaClaudeCodeManagedSettingsRBACGroupsMode
 * @phpstan-type BetaClaudeCodeManagedSettingsModeShape = BetaClaudeCodeManagedSettingsModeVariants|BetaClaudeCodeManagedSettingsOrganizationModeShape|BetaClaudeCodeManagedSettingsRBACGroupsModeShape
 */
final class BetaClaudeCodeManagedSettingsMode implements ConverterSource
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
            'organization' => BetaClaudeCodeManagedSettingsOrganizationMode::class,
            'rbac_groups' => BetaClaudeCodeManagedSettingsRBACGroupsMode::class,
        ];
    }
}
