<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A bucket that a region has retired. Until `expires_at`, keep the bucket and Anthropic's access to it as they were when the bucket passed verification.
 *
 * @phpstan-type BetaGoogleManagedProjectRetiredBucketShape = array{
 *   bucketName: string,
 *   expiresAt: \DateTimeInterface,
 *   projectNumber: string,
 *   region: string,
 * }
 */
final class BetaGoogleManagedProjectRetiredBucket implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectRetiredBucketShape> */
    use SdkModel;

    /**
     * The bucket's Cloud Storage name.
     */
    #[Required('bucket_name')]
    public string $bucketName;

    /**
     * When this entry is removed, in RFC 3339 format.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * The number of the Google Cloud project that holds the bucket, in decimal.
     */
    #[Required('project_number')]
    public string $projectNumber;

    /**
     * The code of the region that retired the bucket.
     */
    #[Required]
    public string $region;

    /**
     * `new BetaGoogleManagedProjectRetiredBucket()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectRetiredBucket::with(
     *   bucketName: ..., expiresAt: ..., projectNumber: ..., region: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectRetiredBucket())
     *   ->withBucketName(...)
     *   ->withExpiresAt(...)
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
        \DateTimeInterface $expiresAt,
        string $projectNumber,
        string $region,
    ): self {
        $self = new self;

        $self['bucketName'] = $bucketName;
        $self['expiresAt'] = $expiresAt;
        $self['projectNumber'] = $projectNumber;
        $self['region'] = $region;

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
     * When this entry is removed, in RFC 3339 format.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

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

    /**
     * The code of the region that retired the bucket.
     */
    public function withRegion(string $region): self
    {
        $self = clone $this;
        $self['region'] = $region;

        return $self;
    }
}
