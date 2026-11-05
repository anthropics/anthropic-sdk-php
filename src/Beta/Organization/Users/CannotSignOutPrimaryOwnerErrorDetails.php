<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The member is the organization's primary owner, whom no API key or token can sign out.
 *
 * @phpstan-type CannotSignOutPrimaryOwnerErrorDetailsShape = array{
 *   errorCode: 'cannot_sign_out_primary_owner'
 * }
 */
final class CannotSignOutPrimaryOwnerErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotSignOutPrimaryOwnerErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_sign_out_primary_owner' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('cannot_sign_out_primary_owner')
    )]
    public string $errorCode = 'cannot_sign_out_primary_owner';

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
     * @param 'cannot_sign_out_primary_owner' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
