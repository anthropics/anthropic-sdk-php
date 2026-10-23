<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTargetCreate\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaClaudeTagSlackChannelBundleTargetCreateShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackChannelBundleTargetCreate
 * @phpstan-import-type BetaClaudeTagSlackWorkspaceBundleTargetCreateShape from \Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagSlackWorkspaceBundleTargetCreate
 *
 * @phpstan-type BetaClaudeTagBundleTargetCreateVariants = BetaClaudeTagSlackChannelBundleTargetCreate|BetaClaudeTagSlackWorkspaceBundleTargetCreate
 * @phpstan-type BetaClaudeTagBundleTargetCreateShape = BetaClaudeTagBundleTargetCreateVariants|BetaClaudeTagSlackChannelBundleTargetCreateShape|BetaClaudeTagSlackWorkspaceBundleTargetCreateShape
 */
final class BetaClaudeTagBundleTargetCreate implements ConverterSource
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
            'slack_channel' => BetaClaudeTagSlackChannelBundleTargetCreate::class,
            'slack_workspace' => BetaClaudeTagSlackWorkspaceBundleTargetCreate::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::SLACK_CHANNEL|'slack_channel' ? BetaClaudeTagSlackChannelBundleTargetCreate : ($type is Type::SLACK_WORKSPACE|'slack_workspace' ? BetaClaudeTagSlackWorkspaceBundleTargetCreate : BetaClaudeTagSlackChannelBundleTargetCreate|BetaClaudeTagSlackWorkspaceBundleTargetCreate))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $slackChannelID = null,
        ?string $slackWorkspaceID = null,
    ): BetaClaudeTagSlackChannelBundleTargetCreate|BetaClaudeTagSlackWorkspaceBundleTargetCreate {
        return match ($type) {
            Type::SLACK_CHANNEL, 'slack_channel' => BetaClaudeTagSlackChannelBundleTargetCreate::with(
                slackChannelID: $slackChannelID ?? throw new \ArgumentCountError('$slackChannelID is required'),
            ),
            Type::SLACK_WORKSPACE, 'slack_workspace' => BetaClaudeTagSlackWorkspaceBundleTargetCreate::with(
                slackWorkspaceID: $slackWorkspaceID ?? throw new \ArgumentCountError('$slackWorkspaceID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
