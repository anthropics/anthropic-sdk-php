<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * This storage is bound to a different user profile from storage the Workspace has attached, or from active or draining storage it once had for safeguards data. Detaching storage the Workspace uses only for transcripts clears this. Detaching safeguards storage doesn't, so use a new Workspace instead.
 *
 * @phpstan-type StorageProfileStillRequiredErrorDetailsShape = array{
 *   errorCode: 'storage_profile_still_required'
 * }
 */
final class StorageProfileStillRequiredErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageProfileStillRequiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_profile_still_required' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('storage_profile_still_required')
    )]
    public string $errorCode = 'storage_profile_still_required';

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
     * @param 'storage_profile_still_required' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
