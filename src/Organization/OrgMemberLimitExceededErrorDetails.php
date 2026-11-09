<?php

declare(strict_types=1);

namespace Anthropic\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization has reached the member limit that Anthropic set for it. Pending invites count toward the limit.
 *
 * @phpstan-type OrgMemberLimitExceededErrorDetailsShape = array{
 *   errorCode: 'org_member_limit_exceeded'
 * }
 */
final class OrgMemberLimitExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<OrgMemberLimitExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'org_member_limit_exceeded' $errorCode */
    #[Required('error_code', type: new ConstantOf('org_member_limit_exceeded'))]
    public string $errorCode = 'org_member_limit_exceeded';

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
     * @param 'org_member_limit_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
