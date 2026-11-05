<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The member is an owner or has owner permissions, and this API key or token cannot sign them out. In a Claude Enterprise organization, an API key with the `write:members` scope can.
 *
 * @phpstan-type CannotSignOutOwnerErrorDetailsShape = array{
 *   errorCode: 'cannot_sign_out_owner'
 * }
 */
final class CannotSignOutOwnerErrorDetails implements BaseModel
{
    /** @use SdkModel<CannotSignOutOwnerErrorDetailsShape> */
    use SdkModel;

    /** @var 'cannot_sign_out_owner' $errorCode */
    #[Required('error_code', type: new ConstantOf('cannot_sign_out_owner'))]
    public string $errorCode = 'cannot_sign_out_owner';

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
     * @param 'cannot_sign_out_owner' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
