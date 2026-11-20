<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The Workspace has reached its limit of 100 different External Storage resources attached over its lifetime. Detached storage counts toward the limit until it is deleted.
 *
 * @phpstan-type StorageAttachLimitReachedErrorDetailsShape = array{
 *   errorCode: 'storage_attach_limit_reached'
 * }
 */
final class StorageAttachLimitReachedErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageAttachLimitReachedErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_attach_limit_reached' $errorCode */
    #[Required(
        'error_code',
        type: new ConstantOf('storage_attach_limit_reached')
    )]
    public string $errorCode = 'storage_attach_limit_reached';

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
     * @param 'storage_attach_limit_reached' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
