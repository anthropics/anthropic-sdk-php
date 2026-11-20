<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * External Storage isn't available for this Workspace, so only `internal` storage is accepted. The error's `message` says why.
 *
 * @phpstan-type ExternalStorageNotAvailableErrorDetailsShape = array{
 *   errorCode: 'external_storage_not_available'
 * }
 */
final class ExternalStorageNotAvailableErrorDetails implements BaseModel
{
    /** @use SdkModel<ExternalStorageNotAvailableErrorDetailsShape> */
    use SdkModel;

    /** @var 'external_storage_not_available' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('external_storage_not_available')
    )]
    public string $errorCode = 'external_storage_not_available';

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
     * @param 'external_storage_not_available' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
