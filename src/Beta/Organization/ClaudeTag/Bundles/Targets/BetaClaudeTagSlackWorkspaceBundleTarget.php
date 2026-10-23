<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * One Bundle attached to one Slack workspace. The Bundle can be used in the workspace and in every channel in it.
 *
 * @phpstan-type BetaClaudeTagSlackWorkspaceBundleTargetShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   slackWorkspaceID: string,
 *   type: 'slack_workspace',
 * }
 */
final class BetaClaudeTagSlackWorkspaceBundleTarget implements BaseModel
{
    /** @use SdkModel<BetaClaudeTagSlackWorkspaceBundleTargetShape> */
    use SdkModel;

    /** @var 'slack_workspace' $type */
    #[Required(type: new ConstantOf('slack_workspace'))]
    public string $type = 'slack_workspace';

    /**
     * The Bundle Target's identifier. Starts with `btgt_`. No two Bundle Targets have the same one, and the same Bundle and target always give the same one, also after a detach and a new attach. It is opaque.
     */
    #[Required]
    public string $id;

    /**
     * Time the Bundle was attached.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * The identifier of the Slack workspace the Bundle is attached to, starting with `slws_`.
     */
    #[Required('slack_workspace_id')]
    public string $slackWorkspaceID;

    /**
     * `new BetaClaudeTagSlackWorkspaceBundleTarget()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaClaudeTagSlackWorkspaceBundleTarget::with(
     *   id: ..., createdAt: ..., slackWorkspaceID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaClaudeTagSlackWorkspaceBundleTarget())
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withSlackWorkspaceID(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $slackWorkspaceID
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['slackWorkspaceID'] = $slackWorkspaceID;

        return $self;
    }

    /**
     * The Bundle Target's identifier. Starts with `btgt_`. No two Bundle Targets have the same one, and the same Bundle and target always give the same one, also after a detach and a new attach. It is opaque.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Time the Bundle was attached.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * The identifier of the Slack workspace the Bundle is attached to, starting with `slws_`.
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
