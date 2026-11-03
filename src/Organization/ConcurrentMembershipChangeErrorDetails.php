<?php

declare(strict_types=1);

namespace Anthropic\Organization;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Another change to the organization's members is in progress. Retry the request once it completes.
 *
 * @phpstan-type ConcurrentMembershipChangeErrorDetailsShape = array{
 *   errorCode: 'concurrent_membership_change'
 * }
 */
final class ConcurrentMembershipChangeErrorDetails implements BaseModel
{
    /** @use SdkModel<ConcurrentMembershipChangeErrorDetailsShape> */
    use SdkModel;

    /** @var 'concurrent_membership_change' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('concurrent_membership_change')
    )]
    public string $errorCode = 'concurrent_membership_change';

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
     * @param 'concurrent_membership_change' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
