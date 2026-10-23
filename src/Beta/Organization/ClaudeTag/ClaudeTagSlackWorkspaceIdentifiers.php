<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The identifier Slack shows for a workspace. It is Slack's own, not an identifier of this API.
 *
 * @phpstan-type ClaudeTagSlackWorkspaceIdentifiersShape = array{
 *   workspaceID: string
 * }
 */
final class ClaudeTagSlackWorkspaceIdentifiers implements BaseModel
{
    /** @use SdkModel<ClaudeTagSlackWorkspaceIdentifiersShape> */
    use SdkModel;

    /**
     * Slack's identifier for the workspace, starting with `T`, such as `T0123ABCD`.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new ClaudeTagSlackWorkspaceIdentifiers()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ClaudeTagSlackWorkspaceIdentifiers::with(workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ClaudeTagSlackWorkspaceIdentifiers())->withWorkspaceID(...)
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
    public static function with(string $workspaceID): self
    {
        $self = new self;

        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Slack's identifier for the workspace, starting with `T`, such as `T0123ABCD`.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
