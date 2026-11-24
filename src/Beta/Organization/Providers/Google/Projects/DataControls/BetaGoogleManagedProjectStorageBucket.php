<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The bucket configured for a region.
 *
 * @phpstan-type BetaGoogleManagedProjectStorageBucketShape = array{
 *   bucketName: string,
 *   kmsKeyName: string|null,
 *   location: string|null,
 *   projectID: string|null,
 *   projectNumber: string,
 * }
 */
final class BetaGoogleManagedProjectStorageBucket implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageBucketShape> */
    use SdkModel;

    /**
     * The bucket's Cloud Storage name.
     */
    #[Required('bucket_name')]
    public string $bucketName;

    /**
     * The resource name of the Cloud KMS key that the bucket encrypts objects under by default. `null` until the region has confirmed the bucket, and when the bucket has no default key.
     */
    #[Required('kms_key_name')]
    public ?string $kmsKeyName;

    /**
     * The bucket's location, as Cloud Storage reports it. `null` until the region has confirmed the bucket.
     */
    #[Required]
    public ?string $location;

    /**
     * The ID of the project that holds the bucket. `null` until the region has confirmed the bucket.
     */
    #[Required('project_id')]
    public ?string $projectID;

    /**
     * The number of the Google Cloud project that holds the bucket, in decimal.
     */
    #[Required('project_number')]
    public string $projectNumber;

    /**
     * `new BetaGoogleManagedProjectStorageBucket()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageBucket::with(
     *   bucketName: ...,
     *   kmsKeyName: ...,
     *   location: ...,
     *   projectID: ...,
     *   projectNumber: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageBucket())
     *   ->withBucketName(...)
     *   ->withKMSKeyName(...)
     *   ->withLocation(...)
     *   ->withProjectID(...)
     *   ->withProjectNumber(...)
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
        ?string $kmsKeyName,
        ?string $location,
        ?string $projectID,
        string $projectNumber,
    ): self {
        $self = new self;

        $self['bucketName'] = $bucketName;
        $self['kmsKeyName'] = $kmsKeyName;
        $self['location'] = $location;
        $self['projectID'] = $projectID;
        $self['projectNumber'] = $projectNumber;

        return $self;
    }

    /**
     * The bucket's Cloud Storage name.
     */
    public function withBucketName(string $bucketName): self
    {
        $self = clone $this;
        $self['bucketName'] = $bucketName;

        return $self;
    }

    /**
     * The resource name of the Cloud KMS key that the bucket encrypts objects under by default. `null` until the region has confirmed the bucket, and when the bucket has no default key.
     */
    public function withKMSKeyName(?string $kmsKeyName): self
    {
        $self = clone $this;
        $self['kmsKeyName'] = $kmsKeyName;

        return $self;
    }

    /**
     * The bucket's location, as Cloud Storage reports it. `null` until the region has confirmed the bucket.
     */
    public function withLocation(?string $location): self
    {
        $self = clone $this;
        $self['location'] = $location;

        return $self;
    }

    /**
     * The ID of the project that holds the bucket. `null` until the region has confirmed the bucket.
     */
    public function withProjectID(?string $projectID): self
    {
        $self = clone $this;
        $self['projectID'] = $projectID;

        return $self;
    }

    /**
     * The number of the Google Cloud project that holds the bucket, in decimal.
     */
    public function withProjectNumber(string $projectNumber): self
    {
        $self = clone $this;
        $self['projectNumber'] = $projectNumber;

        return $self;
    }
}
