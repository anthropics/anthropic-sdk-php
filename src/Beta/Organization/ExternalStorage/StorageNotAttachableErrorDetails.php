<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * This External Storage can't be attached to the setting named in `field`. The error's `message` says why.
 *
 * @phpstan-type StorageNotAttachableErrorDetailsShape = array{
 *   errorCode: 'storage_not_attachable', field: string
 * }
 */
final class StorageNotAttachableErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageNotAttachableErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_not_attachable' $errorCode */
    #[Required('error_code', type: new ConstantOf('storage_not_attachable'))]
    public string $errorCode = 'storage_not_attachable';

    /**
     * The request field at fault.
     */
    #[Required]
    public string $field;

    /**
     * `new StorageNotAttachableErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StorageNotAttachableErrorDetails::with(field: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StorageNotAttachableErrorDetails())->withField(...)
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
     * @param 'storage_not_attachable' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The request field at fault.
     */
    public function withField(string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }
}
