<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The value comes from the addressed channel as it is set up under another workspace of its Enterprise Grid: a channel shared across the Grid keeps one Slack channel identifier in every workspace that sees it.
 *
 * @phpstan-import-type ClaudeTagSlackChannelIdentifiersShape from \Anthropic\Beta\Organization\ClaudeTag\ClaudeTagSlackChannelIdentifiers
 *
 * @phpstan-type ClaudeTagSlackGridChannelSettingSourceShape = array{
 *   slack: ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape,
 *   type: 'slack_grid_channel',
 * }
 */
final class ClaudeTagSlackGridChannelSettingSource implements BaseModel
{
    /** @use SdkModel<ClaudeTagSlackGridChannelSettingSourceShape> */
    use SdkModel;

    /** @var 'slack_grid_channel' $type */
    #[Required(type: new ConstantOf('slack_grid_channel'))]
    public string $type = 'slack_grid_channel';

    /**
     * Slack's own identifiers for the channel under that other workspace.
     */
    #[Required]
    public ClaudeTagSlackChannelIdentifiers $slack;

    /**
     * `new ClaudeTagSlackGridChannelSettingSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSlackGridChannelSettingSource::with(slack: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClaudeTagSlackGridChannelSettingSource())->withSlack(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape $slack
     */
    public static function with(
        ClaudeTagSlackChannelIdentifiers|array $slack
    ): self {
        $self = new self;

        $self['slack'] = $slack;

        return $self;
    }

    /**
     * Slack's own identifiers for the channel under that other workspace.
     *
     * @param ClaudeTagSlackChannelIdentifiers|ClaudeTagSlackChannelIdentifiersShape $slack
     */
    public function withSlack(
        ClaudeTagSlackChannelIdentifiers|array $slack
    ): self {
        $self = clone $this;
        $self['slack'] = $slack;

        return $self;
    }

    /**
     * @param 'slack_grid_channel' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
