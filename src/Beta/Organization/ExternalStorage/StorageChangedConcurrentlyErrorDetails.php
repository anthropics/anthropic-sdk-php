<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Another request changed this storage setting while this one was running, so this request left it as it is. Read the Workspace and send the request again if you still want the change.
 *
 * @phpstan-type StorageChangedConcurrentlyErrorDetailsShape = array{
 *   errorCode: 'storage_changed_concurrently', field: string
 * }
 */
final class StorageChangedConcurrentlyErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageChangedConcurrentlyErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_changed_concurrently' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('storage_changed_concurrently')
    )]
    public string $errorCode = 'storage_changed_concurrently';

    /**
     * The storage setting that changed.
     */
    #[Required]
    public string $field;

    /**
     * `new StorageChangedConcurrentlyErrorDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * StorageChangedConcurrentlyErrorDetails::with(field: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new StorageChangedConcurrentlyErrorDetails())->withField(...)
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
     * @param 'storage_changed_concurrently' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }

    /**
     * The storage setting that changed.
     */
    public function withField(string $field): self
    {
        $self = clone $this;
        $self['field'] = $field;

        return $self;
    }
}
