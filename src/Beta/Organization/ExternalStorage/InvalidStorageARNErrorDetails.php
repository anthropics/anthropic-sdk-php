<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * On Claude Platform on AWS, the External Storage ID in the request is neither a bucket ARN nor an `estrg_` ID, or is the `estrg_` ID of AWS storage. Name AWS storage by its bucket ARN, `arn:<partition>:s3:::<bucket_name>`, which responses return as its `id`.
 *
 * @phpstan-type InvalidStorageARNErrorDetailsShape = array{
 *   errorCode: 'invalid_storage_arn'
 * }
 */
final class InvalidStorageARNErrorDetails implements BaseModel
{
    /** @use SdkModel<InvalidStorageARNErrorDetailsShape> */
    use SdkModel;

    /** @var 'invalid_storage_arn' $errorCode */
    #[Required('error_code', type: new ConstantOf('invalid_storage_arn'))]
    public string $errorCode = 'invalid_storage_arn';

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
     * @param 'invalid_storage_arn' $errorCode
     */
    public function withErrorCode(string $errorCode): self
    {
        $self = clone $this;
        $self['errorCode'] = $errorCode;

        return $self;
    }
}
