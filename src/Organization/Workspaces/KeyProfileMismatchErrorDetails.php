<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * After this request, the External Key and the Workspace would not have the same user profile. A key and its Workspace must have the same user profile, or both have none.
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
