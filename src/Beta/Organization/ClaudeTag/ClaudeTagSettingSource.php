<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The settings level a value comes from. More types can be added.
 *
 * @phpstan-import-type ClaudeTagSlackChannelSettingSourceShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelSettingSource
 * @phpstan-import-type ClaudeTagSlackWorkspaceSettingSourceShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackWorkspaceSettingSource
 * @phpstan-import-type ClaudeTagSlackParentChannelSettingSourceShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackParentChannelSettingSource
 * @phpstan-import-type ClaudeTagSlackDefaultSettingSourceShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackDefaultSettingSource
 * @phpstan-import-type ClaudeTagDefaultSettingSourceShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagDefaultSettingSource
 * @phpstan-import-type ClaudeTagSlackGridChannelSettingSourceShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackGridChannelSettingSource
 *
 * @phpstan-type ClaudeTagSettingSourceVariants = ClaudeTagSlackChannelSettingSource|ClaudeTagSlackWorkspaceSettingSource|ClaudeTagSlackParentChannelSettingSource|ClaudeTagSlackDefaultSettingSource|ClaudeTagDefaultSettingSource|ClaudeTagSlackGridChannelSettingSource
 * @phpstan-type ClaudeTagSettingSourceShape = ClaudeTagSettingSourceVariants|ClaudeTagSlackChannelSettingSourceShape|ClaudeTagSlackWorkspaceSettingSourceShape|ClaudeTagSlackParentChannelSettingSourceShape|ClaudeTagSlackDefaultSettingSourceShape|ClaudeTagDefaultSettingSourceShape|ClaudeTagSlackGridChannelSettingSourceShape
 */
final class ClaudeTagSettingSource implements ConverterSource
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
            'slack_channel' => ClaudeTagSlackChannelSettingSource::class,
            'slack_workspace' => ClaudeTagSlackWorkspaceSettingSource::class,
            'slack_parent_channel' => ClaudeTagSlackParentChannelSettingSource::class,
            'slack_default' => ClaudeTagSlackDefaultSettingSource::class,
            'default' => ClaudeTagDefaultSettingSource::class,
            'slack_grid_channel' => ClaudeTagSlackGridChannelSettingSource::class,
        ];
    }
}
