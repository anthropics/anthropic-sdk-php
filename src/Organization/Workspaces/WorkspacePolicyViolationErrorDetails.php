<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request breaks the organization's Workspace Policy. The message says which rule it broke; an organization admin can see and change the policy in the Console.
 *
 * @phpstan-type WorkspacePolicyViolationErrorDetailsShape = array{
 *   errorCode: 'workspace_policy_violation',
 *   field: WorkspacePolicyField|value-of<WorkspacePolicyField>,
 * }
 */
final class WorkspacePolicyViolationErrorDetails implements BaseModel
{
    /** @use SdkModel<WorkspacePolicyViolationErrorDetailsShape> */
    use SdkModel;

    /** @var 'workspace_policy_violation' $errorCode */
    #[Required('error_code', type: new ConstantOf('workspace_policy_violation'))]
    public string $errorCode = 'workspace_policy_violation';

    /**
     * The request field the broken rule applies to.
     *
     * @var value-of<WorkspacePolicyField> $field
     */
    #[Required(enum: WorkspacePolicyField::class)]
    public string $field;

    /**
     * `new WorkspacePolicyViolationErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspacePolicyViolationErrorDetails::with(field: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspacePolicyViolationErrorDetails())->withField(...)
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
     * @param WorkspacePolicyField|value-of<WorkspacePolicyField> $field
     */
    public static function with(WorkspacePolicyField|string $field): self
    {
        $self = new self;

        $self['field'] = $field;

        return $self;
    }

    /**
     * @param 'workspace_policy_violation' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The request field the broken rule applies to.
     *
     * @param WorkspacePolicyField|value-of<WorkspacePolicyField> $field
     */
    public function withField(WorkspacePolicyField|string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }
}
