<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The External Storage is `active` or `draining`, so this delete didn't erase it. The message says what to do next. On `draining` storage this delete may have started a removal that can't be undone: get the storage and read `status.removal_started`.
 *
 * @phpstan-type ExternalStorageInUseErrorDetailsShape = array{
 *   errorCode: 'external_storage_in_use'
 * }
 */
final class ExternalStorageInUseErrorDetails implements BaseModel
{
    /** @use SdkModel<ExternalStorageInUseErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_storage_in_use' $errorCode */
    #[Required('error_code', type: new ConstantOf('external_storage_in_use'))]
    public string $errorCode = 'external_storage_in_use';

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
     * @param 'external_storage_in_use' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
