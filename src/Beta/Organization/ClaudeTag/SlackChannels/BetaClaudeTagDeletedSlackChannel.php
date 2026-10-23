<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\SlackChannels;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Confirms that a Slack channel was removed from Claude Tag.
 *
 * @phpstan-type BetaClaudeTagDeletedSlackChannelShape = array{
 *   id: string, type: 'slack_channel_deleted'
 * }
 */
final class BetaClaudeTagDeletedSlackChannel implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagDeletedSlackChannelShape> */
    use SdkModel;

    /** @var 'slack_channel_deleted' $type */
    #[Required(type: new ConstantOf('slack_channel_deleted'))]
    public string $type = 'slack_channel_deleted';

    /**
     * The removed channel's identifier.
     */
    #[Required]
    public string $id;

    /**
     * `new BetaClaudeTagDeletedSlackChannel()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagDeletedSlackChannel::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagDeletedSlackChannel())->withID(...)
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
     */
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * The removed channel's identifier.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * @param 'slack_channel_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
