<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Turning human review off needs Anthropic's approval for the organization, and the organization doesn't have it. Contact Anthropic support to request approval.
 *
 * @phpstan-type BetaApprovalRequiredErrorDetailsShape = array{
 *   errorCode: 'approval_required', field: string
 * }
 */
final class BetaApprovalRequiredErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaApprovalRequiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'approval_required' $errorCode */
    #[Required('error_code', type: new ConstantOf('approval_required'))]
    public string $errorCode = 'approval_required';

    /**
     * The request field that needs the approval.
     */
    #[Required]
    public string $field;

    /**
     * `new BetaApprovalRequiredErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaApprovalRequiredErrorDetails::with(field: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaApprovalRequiredErrorDetails())->withField(...)
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
    public static function with(string $field): self
    {
        $self = new self;

        $self['field'] = $field;

        return $self;
    }

    /**
     * @param 'approval_required' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The request field that needs the approval.
     */
    public function withField(string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }
}
