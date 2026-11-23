<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The organization already has External Storage for this bucket that it has not deleted. List the organization's External Storage to find it.
 *
 * @phpstan-type StorageAlreadyRegisteredErrorDetailsShape = array{
 *   errorCode: 'storage_already_registered'
 * }
 */
final class StorageAlreadyRegisteredErrorDetails implements BaseModel
{
    /** @use SdkModel<StorageAlreadyRegisteredErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_already_registered' $errorCode */
    #[Required('error_code', type: new ConstantOf('storage_already_registered'))]
    public string $errorCode = 'storage_already_registered';

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
     * @param 'storage_already_registered' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
