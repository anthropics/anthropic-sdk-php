<?php

declare(strict_types=1);

namespace Anthropic\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The user is the organization's only member. Add another member before removing this one.
 *
 * @phpstan-type CannotRemoveLastMemberErrorDetailsShape = array{
 *   errorCode: 'cannot_remove_last_member'
 * }
 */
final class CannotRemoveLastMemberErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotRemoveLastMemberErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_remove_last_member' $errorCode */
    #[Required('error_code', type: new ConstantOf('cannot_remove_last_member'))]
    public string $errorCode = 'cannot_remove_last_member';

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
     * @param 'cannot_remove_last_member' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
