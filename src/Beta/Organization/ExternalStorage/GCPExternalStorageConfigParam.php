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
 * @phpstan-type GCPExternalStorageConfigParamShape = array{
 *   bucketName: string, projectNumber: string, region: string, type: 'gcp'
 * }
 */
final class GCPExternalStorageConfigParam implements BaseModel
{
    /** @use SdkModel<GCPExternalStorageConfigParamShape> */
    use SdkModel;

    /** @var 'gcp' $type */
    #[Required(type: new ConstantOf('gcp'))]
    public string $type = 'gcp';

    /**
     * The bucket's name, without `gs://`: 3 to 63 lower-case letters, digits and hyphens, starting and ending with a letter or digit. It can't start with `goog` or contain `google`.
     */
    #[Required('bucket_name')]
    public string $bucketName;

    /**
     * Project number, not project ID, of the Google Cloud project that holds the bucket.
     */
    #[Required('project_number')]
    public string $projectNumber;

    /**
     * The bucket's Google Cloud region, such as `us-east5`: one of the single regions that the setup guide lists. Dual-regions and multi-regions aren't supported.
     */
    #[Required]
    public string $region;

    /**
     * `new GCPExternalStorageConfigParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * GCPExternalStorageConfigParam::with(
     *   bucketName: ..., projectNumber: ..., region: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new GCPExternalStorageConfigParam())
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
     * The bucket's name, without `gs://`: 3 to 63 lower-case letters, digits and hyphens, starting and ending with a letter or digit. It can't start with `goog` or contain `google`.
     */
    public function withBucketName(string $bucketName): self
    {
        $self = clone $this;
        $self['bucketName'] = $bucketName;

        return $self;
    }

    /**
     * Project number, not project ID, of the Google Cloud project that holds the bucket.
     */
    public function withProjectNumber(string $projectNumber): self
    {
        $self = clone $this;
        $self['projectNumber'] = $projectNumber;

        return $self;
    }

    /**
     * The bucket's Google Cloud region, such as `us-east5`: one of the single regions that the setup guide lists. Dual-regions and multi-regions aren't supported.
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
