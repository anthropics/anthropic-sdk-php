<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * One Bundle attached to one Slack channel or one Slack workspace. More types of target can be added.
 *
 * @phpstan-import-type BetaClaudeTagSlackChannelBundleTargetShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTarget
 * @phpstan-import-type BetaClaudeTagSlackWorkspaceBundleTargetShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTarget
 *
 * @phpstan-type BetaClaudeTagBundleTargetVariants = BetaClaudeTagSlackChannelBundleTarget|BetaClaudeTagSlackWorkspaceBundleTarget
 * @phpstan-type BetaClaudeTagBundleTargetShape = BetaClaudeTagBundleTargetVariants|BetaClaudeTagSlackChannelBundleTargetShape|BetaClaudeTagSlackWorkspaceBundleTargetShape
 */
final class BetaClaudeTagBundleTarget implements ConverterSource
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
            'slack_channel' => BetaClaudeTagSlackChannelBundleTarget::class,
            'slack_workspace' => BetaClaudeTagSlackWorkspaceBundleTarget::class,
        ];
    }
}
