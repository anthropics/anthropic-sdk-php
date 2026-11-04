<?php

declare(strict_types=1);

namespace Anthropic\Files;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The file's `expires_at` has passed, so its content is no longer available.
 *
 * @phpstan-type FileExpiredErrorDetailsShape = array{errorCode: 'file_expired'}
 */
final class FileExpiredErrorDetails implements BaseModel
{
    /** @use SdkModel<FileExpiredErrorDetailsShape> */
    use SdkModel;

    /** @var 'file_expired' $errorCode */
    #[Required('error_code', type: new ConstantOf('file_expired'))]
    public string $errorCode = 'file_expired';

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
     * @param 'file_expired' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
