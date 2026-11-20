<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Another request changed the Workspace, so this request left the setting named in `field` as it is. The error's `message` says which of this request's other changes are in place. Read the Workspace and send the request again if you still want the change.
 *
 * @phpstan-type WorkspaceChangedConcurrentlyErrorDetailsShape = array{
 *   errorCode: 'workspace_changed_concurrently',
 *   field: WorkspaceChangedConcurrentlyField|value-of<WorkspaceChangedConcurrentlyField>,
 * }
 */
final class WorkspaceChangedConcurrentlyErrorDetails implements BaseModel
{
    /** @use SdkModel<WorkspaceChangedConcurrentlyErrorDetailsShape> */
    use SdkModel;

    /** @var 'workspace_changed_concurrently' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('workspace_changed_concurrently')
    )]
    public string $errorCode = 'workspace_changed_concurrently';

    /**
     * The request field whose change was refused. Other values may be returned. The value is a name with no data of its own.
     *
     * @var value-of<WorkspaceChangedConcurrentlyField> $field
     */
    #[Required(enum: WorkspaceChangedConcurrentlyField::class)]
    public string $field;

    /**
     * `new WorkspaceChangedConcurrentlyErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceChangedConcurrentlyErrorDetails::with(field: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceChangedConcurrentlyErrorDetails())->withField(...)
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
     * @param WorkspaceChangedConcurrentlyField|value-of<WorkspaceChangedConcurrentlyField> $field
     */
    public static function with(
        WorkspaceChangedConcurrentlyField|string $field
    ): self {
        $self = new self;

        $self['field'] = $field;

        return $self;
    }

    /**
     * @param 'workspace_changed_concurrently' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The request field whose change was refused. Other values may be returned. The value is a name with no data of its own.
     *
     * @param WorkspaceChangedConcurrentlyField|value-of<WorkspaceChangedConcurrentlyField> $field
     */
    public function withField(
        WorkspaceChangedConcurrentlyField|string $field
    ): self {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }
}
