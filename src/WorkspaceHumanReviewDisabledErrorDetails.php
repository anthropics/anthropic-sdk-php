<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The request's Workspace has Human Review turned off, and this operation is not available there. Use a Workspace with Human Review on.
 *
 * @phpstan-type WorkspaceHumanReviewDisabledErrorDetailsShape = array{
 *   errorCode: 'workspace_human_review_disabled'
 * }
 */
final class WorkspaceHumanReviewDisabledErrorDetails implements BaseModel
{
    /** @use SdkModel<WorkspaceHumanReviewDisabledErrorDetailsShape> */
    use SdkModel;

    /** @var 'workspace_human_review_disabled' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('workspace_human_review_disabled')
    )]
    public string $errorCode = 'workspace_human_review_disabled';

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
     * @param 'workspace_human_review_disabled' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
