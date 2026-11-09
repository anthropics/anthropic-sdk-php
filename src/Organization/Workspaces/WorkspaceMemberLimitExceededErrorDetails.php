<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The workspace has reached the member limit that Anthropic set for it.
 *
 * @phpstan-type WorkspaceMemberLimitExceededErrorDetailsShape = array{
 *   errorCode: 'workspace_member_limit_exceeded'
 * }
 */
final class WorkspaceMemberLimitExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<WorkspaceMemberLimitExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'workspace_member_limit_exceeded' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('workspace_member_limit_exceeded')
    )]
    public string $errorCode = 'workspace_member_limit_exceeded';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * @param 'workspace_member_limit_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
