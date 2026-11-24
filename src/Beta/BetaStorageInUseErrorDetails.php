<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The bucket is already in use, or was in use recently. Name a different bucket.
 *
 * @phpstan-type BetaStorageInUseErrorDetailsShape = array{
 *   errorCode: 'storage_in_use'
 * }
 */
final class BetaStorageInUseErrorDetails implements BaseModel
{
    /** @use SdkModel<BetaStorageInUseErrorDetailsShape> */
    use SdkModel;

    /** @var 'storage_in_use' $errorCode */
    #[Required('error_code', type: new ConstantOf('storage_in_use'))]
    public string $errorCode = 'storage_in_use';

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
     * @param 'storage_in_use' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
