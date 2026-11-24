<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Core\Conversion\MapOf;

/**
 * Turns the control on, or changes its buckets while it is on.
 *
 * @phpstan-import-type BetaGoogleManagedBucketReferenceShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedBucketReference
 *
 * @phpstan-type BetaGoogleManagedStorageEnabledParamsShape = array{
 *   type: 'enabled',
 *   buckets?: array<string,null|BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape>|null,
 * }
 */
final class BetaGoogleManagedStorageEnabledParams implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageEnabledParamsShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * The bucket to use in each region, keyed by region code, such as `us` or `eu`. An object with `project_number` and `bucket_name` sets that region's bucket, `null` removes it, and a region you leave out keeps its bucket. A bucket can serve only one region. While the control is on, at least one region must have a bucket.
     *
     * @var array<string,BetaGoogleManagedBucketReference|null>|null $buckets
     */
    #[Optional(
        type: new MapOf(BetaGoogleManagedBucketReference::class, nullable: true)
    )]
    public ?array $buckets;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param array<string,BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape|null>|null $buckets
     */
    public static function with(?array $buckets = null): self
    {
        $self = new self;

        null !== $buckets && $self['buckets'] = $buckets;

        return $self;
    }

    /**
     * @param 'enabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The bucket to use in each region, keyed by region code, such as `us` or `eu`. An object with `project_number` and `bucket_name` sets that region's bucket, `null` removes it, and a region you leave out keeps its bucket. A bucket can serve only one region. While the control is on, at least one region must have a bucket.
     *
     * @param array<string,BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape|null> $buckets
     */
    public function withBuckets(array $buckets): self
    {
        $self = clone $this;
        $self['buckets'] = $buckets;

        return $self;
    }
}
