<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The email address already belongs to a user in the organization. The message names the user.
 *
 * @phpstan-type AlreadyMemberErrorDetailsShape = array{
 *   errorCode: 'already_member'
 * }
 */
final class AlreadyMemberErrorDetails implements BaseModel
{
    /** @use SdkModel<AlreadyMemberErrorDetailsShape> */
    use SdkModel;

    /** @var 'already_member' $errorCode */
    #[Required('error_code', type: new ConstantOf('already_member'))]
    public string $errorCode = 'already_member';

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
     * @param 'already_member' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
