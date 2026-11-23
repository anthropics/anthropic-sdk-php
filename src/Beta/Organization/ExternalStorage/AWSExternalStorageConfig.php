<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * An Amazon S3 bucket.
 *
 * @phpstan-type AWSExternalStorageConfigShape = array{
 *   accountID: string, bucketName: string, region: string, type: 'aws'
 * }
 */
final class AWSExternalStorageConfig implements BaseModel
{
    /** @use SdkModel<AWSExternalStorageConfigShape> */
    use SdkModel;

    /** @var 'aws' $type */
    #[Required(type: new ConstantOf('aws'))]
    public string $type = 'aws';

    /**
     * 12-digit ID of the AWS account that owns the bucket.
     */
    #[Required('account_id')]
    public string $accountID;

    /**
     * The bucket's name, without `s3://`.
     */
    #[Required('bucket_name')]
    public string $bucketName;

    /**
     * The bucket's AWS region.
     */
    #[Required]
    public string $region;

    /**
     * `new AWSExternalStorageConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AWSExternalStorageConfig::with(accountID: ..., bucketName: ..., region: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AWSExternalStorageConfig())
     *   ->withAccountID(...)
     *   ->withBucketName(...)
     *   ->withRegion(...)
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
    public static function with(
        string $accountID,
        string $bucketName,
        string $region
    ): self {
        $self = new self;

        $self['accountID'] = $accountID;
        $self['bucketName'] = $bucketName;
        $self['region'] = $region;

        return $self;
    }

    /**
     * 12-digit ID of the AWS account that owns the bucket.
     */
    public function withAccountID(string $accountID): self
    {
        $self = clone $this;
        $self['accountID'] = $accountID;

        return $self;
    }

    /**
     * The bucket's name, without `s3://`.
     */
    public function withBucketName(string $bucketName): self
    {
        $self = clone $this;
        $self['bucketName'] = $bucketName;

        return $self;
    }

    /**
     * The bucket's AWS region.
     */
    public function withRegion(string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    /**
     * @param 'aws' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
