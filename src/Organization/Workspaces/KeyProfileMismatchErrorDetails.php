<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The External Key is bound to a user profile, and the Workspace does not have that user profile. A Workspace can use only a key bound to its own user profile or a key that isn't bound to one.
 *
 * @phpstan-type KeyProfileMismatchErrorDetailsShape = array{
 *   errorCode: 'key_profile_mismatch'
 * }
 */
final class KeyProfileMismatchErrorDetails implements BaseModel
{
    /** @use SdkModel<KeyProfileMismatchErrorDetailsShape> */
    use SdkModel;

    /** @var 'key_profile_mismatch' $errorCode */
    #[Required('error_code', type: new ConstantOf('key_profile_mismatch'))]
    public string $errorCode = 'key_profile_mismatch';

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
     * @param 'key_profile_mismatch' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
