<?php

declare(strict_types=1);

namespace Anthropic\Files;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization's file storage quota is exhausted. Delete files to free up space, then retry the upload.
 *
 * @phpstan-type StorageQuotaExceededErrorDetailsShape = array{
 *   errorCode: 'storage_quota_exceeded'
 * }
 */
final class StorageQuotaExceededErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageQuotaExceededErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_quota_exceeded' $errorCode */
    #[Required('error_code', type: new ConstantOf('storage_quota_exceeded'))]
    public string $errorCode = 'storage_quota_exceeded';

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
     * @param 'storage_quota_exceeded' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
