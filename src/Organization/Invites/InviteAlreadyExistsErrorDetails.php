<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A pending invite already exists for the email address. The message names the invite.
 *
 * @phpstan-type InviteAlreadyExistsErrorDetailsShape = array{
 *   errorCode: 'invite_already_exists'
 * }
 */
final class InviteAlreadyExistsErrorDetails implements BaseModel
{
    /** @use SdkModel<InviteAlreadyExistsErrorDetailsShape> */
    use SdkModel;

    /** @var 'invite_already_exists' $errorCode */
    #[Required('error_code', type: new ConstantOf('invite_already_exists'))]
    public string $errorCode = 'invite_already_exists';

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
     * @param 'invite_already_exists' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
