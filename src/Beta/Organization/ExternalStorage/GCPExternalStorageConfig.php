<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A Google Cloud Storage bucket.
 *
 * @phpstan-type GCPExternalStorageConfigShape = array{
 *   bucketName: string, projectNumber: string, region: string, type: 'gcp'
 * }
 */
final class GCPExternalStorageConfig implements BaseModel
{
    /** @use SdkModel<GCPExternalStorageConfigShape> */
    use SdkModel;

    /** @var 'gcp' $type */
    #[Required(type: new ConstantOf('gcp'))]
    public string $type = 'gcp';

    /**
     * The bucket's name, without `gs://`.
     */
    #[Required('bucket_name')]
    public string $bucketName;

    /**
     * Number of the Google Cloud project that holds the bucket.
     */
    #[Required('project_number')]
    public string $projectNumber;

    /**
     * The bucket's Google Cloud region.
     */
    #[Required]
    public string $region;

    /**
     * `new GCPExternalStorageConfig()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GCPExternalStorageConfig::with(bucketName: ..., projectNumber: ..., region: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GCPExternalStorageConfig())
     *   ->withBucketName(...)
     *   ->withProjectNumber(...)
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
        string $bucketName,
        string $projectNumber,
        string $region
    ): self {
        $self = new self;

        $self['bucketName'] = $bucketName;
        $self['projectNumber'] = $projectNumber;
        $self['region'] = $region;

        return $self;
    }

    /**
     * The bucket's name, without `gs://`.
     */
    public function withBucketName(string $bucketName): self
    {
        $self = clone $this;
        $self['bucketName'] = $bucketName;

        return $self;
    }

    /**
     * Number of the Google Cloud project that holds the bucket.
     */
    public function withProjectNumber(string $projectNumber): self
    {
        $self = clone $this;
        $self['projectNumber'] = $projectNumber;

        return $self;
    }

    /**
     * The bucket's Google Cloud region.
     */
    public function withRegion(string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }

    /**
     * @param 'gcp' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
