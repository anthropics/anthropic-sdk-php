<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The value comes from a Slack workspace of the organization.
 *
 * @phpstan-type ClaudeTagSlackWorkspaceSettingSourceShape = array{
 *   slackWorkspaceID: string, type: 'slack_workspace'
 * }
 */
final class ClaudeTagSlackWorkspaceSettingSource implements BaseModel
{
    /** @use SdkModel<ClaudeTagSlackWorkspaceSettingSourceShape> */
    use SdkModel;

    /** @var 'slack_workspace' $type */
    #[Required(type: new ConstantOf('slack_workspace'))]
    public string $type = 'slack_workspace';

    /**
     * The workspace's identifier, starting with `slws_`.
     */
    #[Required('slack_workspace_id')]
    public string $slackWorkspaceID;

    /**
     * `new ClaudeTagSlackWorkspaceSettingSource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSlackWorkspaceSettingSource::with(slackWorkspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClaudeTagSlackWorkspaceSettingSource())->withSlackWorkspaceID(...)
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
    public static function with(string $slackWorkspaceID): self
    {
        $self = new self;

        $self['slackWorkspaceID'] = $slackWorkspaceID;

        return $self;
    }

    /**
     * The workspace's identifier, starting with `slws_`.
     */
    public function withSlackWorkspaceID(string $slackWorkspaceID): self
    {
        $self = clone $this;
        $self['slackWorkspaceID'] = $slackWorkspaceID;

        return $self;
    }

    /**
     * @param 'slack_workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
