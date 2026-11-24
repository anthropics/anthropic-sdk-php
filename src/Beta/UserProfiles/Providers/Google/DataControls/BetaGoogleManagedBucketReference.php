<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A Cloud Storage bucket, named by the project that holds it and by its own name.
 *
 * @phpstan-type BetaGoogleManagedBucketReferenceShape = array{
 *   bucketName: string, projectNumber: string
 * }
 */
final class BetaGoogleManagedBucketReference implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedBucketReferenceShape> */
    use SdkModel;

    /**
     * The bucket's Cloud Storage name.
     */
    #[Required('bucket_name')]
    public string $bucketName;

    /**
     * The number of the Google Cloud project that holds the bucket, in decimal.
     */
    #[Required('project_number')]
    public string $projectNumber;

    /**
     * `new BetaGoogleManagedBucketReference()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedBucketReference::with(bucketName: ..., projectNumber: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedBucketReference())
     *   ->withBucketName(...)
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
    public static function with(string $bucketName, string $projectNumber): self
    {
        $self = new self;

        $self['bucketName'] = $bucketName;
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
     * The number of the Google Cloud project that holds the bucket, in decimal.
     */
    public function withProjectNumber(string $projectNumber): self
    {
        $self = clone $this;
        $self['projectNumber'] = $projectNumber;

        return $self;
    }
}
