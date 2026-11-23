<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The Workspace's storage and its user profile don't match: the Workspace and its storage must have the same user profile, or both have none.
 *
 * @phpstan-type StorageProfileMismatchErrorDetailsShape = array{
 *   errorCode: 'storage_profile_mismatch', field: string
 * }
 */
final class StorageProfileMismatchErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageProfileMismatchErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_profile_mismatch' $errorCode */
    #[Required('error_code', type: new ConstantOf('storage_profile_mismatch'))]
    public string $errorCode = 'storage_profile_mismatch';

    /**
     * The storage setting that doesn't match the Workspace's user profile.
     */
    #[Required]
    public string $field;

    /**
     * `new StorageProfileMismatchErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StorageProfileMismatchErrorDetails::with(field: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StorageProfileMismatchErrorDetails())->withField(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(string $field): self
    {
        $self = new self;

        $self['field'] = $field;

        return $self;
    }

    /**
     * @param 'storage_profile_mismatch' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The storage setting that doesn't match the Workspace's user profile.
     */
    public function withField(string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }
}
