<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Attach the Bundle to a Slack workspace.
 *
 * @phpstan-type BetaClaudeTagSlackWorkspaceBundleTargetCreateShape = array{
 *   slackWorkspaceID: string, type: 'slack_workspace'
 * }
 */
final class BetaClaudeTagSlackWorkspaceBundleTargetCreate implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagSlackWorkspaceBundleTargetCreateShape> */
    use SdkModel;

    /** @var 'slack_workspace' $type */
    #[Required(type: new ConstantOf('slack_workspace'))]
    public string $type = 'slack_workspace';

    /**
     * The identifier of the Slack workspace to attach the Bundle to, starting with `slws_`.
     */
    #[Required('slack_workspace_id')]
    public string $slackWorkspaceID;

    /**
     * `new BetaClaudeTagSlackWorkspaceBundleTargetCreate()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagSlackWorkspaceBundleTargetCreate::with(slackWorkspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagSlackWorkspaceBundleTargetCreate())->withSlackWorkspaceID(...)
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
     * The identifier of the Slack workspace to attach the Bundle to, starting with `slws_`.
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
