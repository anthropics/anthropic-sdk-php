<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\APIKeys;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type APIKeyWorkspaceScopeShape = array{
 *   type: 'workspace', workspaceID: string
 * }
 */
final class APIKeyWorkspaceScope implements BaseModel
{
    /** @use SdkModel<APIKeyWorkspaceScopeShape> */
    use SdkModel;

    /**
     * Scope type. Always `"workspace"`: the API key belongs to one Workspace.
     *
     * @var 'workspace' $type
     */
    #[Required]
    public string $type = 'workspace';

    /**
     * ID of the Workspace the API key belongs to. Unlike the deprecated top-level `workspace_id`, this is the Workspace's real ID even for the organization's default Workspace.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new APIKeyWorkspaceScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * APIKeyWorkspaceScope::with(workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new APIKeyWorkspaceScope)->withWorkspaceID(...)
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
     * Scope type. Always `"workspace"`: the API key belongs to one Workspace.
     *
     * @param 'workspace' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the Workspace the API key belongs to. Unlike the deprecated top-level `workspace_id`, this is the Workspace's real ID even for the organization's default Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
