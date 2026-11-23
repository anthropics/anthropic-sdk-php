<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The Workspace was created, but some of what the request asked for did not take effect, or may not have. Don't send the create again. The error's `message` says what to do with the Workspace at `workspace_id`.
 *
 * @phpstan-type WorkspaceCreatedIncompleteErrorDetailsShape = array{
 *   errorCode: 'workspace_created_incomplete', workspaceID: string
 * }
 */
final class WorkspaceCreatedIncompleteErrorDetails implements BaseModel
{
    /** @use SdkModel<WorkspaceCreatedIncompleteErrorDetailsShape> */
    use SdkModel;

    /** @var 'workspace_created_incomplete' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('workspace_created_incomplete')
    )]
    public string $errorCode = 'workspace_created_incomplete';

    /**
     * ID of the Workspace the request created.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * `new WorkspaceCreatedIncompleteErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceCreatedIncompleteErrorDetails::with(workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceCreatedIncompleteErrorDetails())->withWorkspaceID(...)
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
     * @param 'workspace_created_incomplete' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * ID of the Workspace the request created.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
