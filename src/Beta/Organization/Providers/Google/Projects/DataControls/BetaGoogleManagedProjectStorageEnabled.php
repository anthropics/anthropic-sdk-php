<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The control is on and has a bucket for at least one region.
 *
 * @phpstan-import-type BetaGoogleManagedProjectStorageBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageBucket
 * @phpstan-import-type BetaGoogleManagedProjectRetiredBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectRetiredBucket
 * @phpstan-import-type BetaGoogleManagedProjectStorageRegionStatusShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageRegionStatus
 * @phpstan-import-type BetaGoogleManagedProjectStorageRegionStatusVariants from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageRegionStatus
 *
 * @phpstan-type BetaGoogleManagedProjectStorageEnabledShape = array{
 *   buckets: array<string,BetaGoogleManagedProjectStorageBucket|BetaGoogleManagedProjectStorageBucketShape>,
 *   retiredBuckets: list<BetaGoogleManagedProjectRetiredBucket|BetaGoogleManagedProjectRetiredBucketShape>,
 *   status: array<string,BetaGoogleManagedProjectStorageRegionStatusShape>,
 *   type: 'enabled',
 * }
 */
final class BetaGoogleManagedProjectStorageEnabled implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageEnabledShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * The bucket configured for each region, keyed by region code. A region with no bucket is left out.
     *
     * @var array<string,BetaGoogleManagedProjectStorageBucket> $buckets
     */
    #[Required(map: BetaGoogleManagedProjectStorageBucket::class)]
    public array $buckets;

    /**
     * Buckets that a region has retired, earliest `expires_at` first.
     *
     * @var list<BetaGoogleManagedProjectRetiredBucket> $retiredBuckets
     */
    #[Required(
        'retired_buckets',
        list: BetaGoogleManagedProjectRetiredBucket::class
    )]
    public array $retiredBuckets;

    /**
     * Each region's status for the control, keyed by region code. A region that your organization is not offered may have no entry, and Anthropic may add regions.
     *
     * @var array<string,BetaGoogleManagedProjectStorageRegionStatusVariants> $status
     */
    #[Required(map: BetaGoogleManagedProjectStorageRegionStatus::class)]
    public array $status;

    /**
     * `new BetaGoogleManagedProjectStorageEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageEnabled::with(
     *   buckets: ..., retiredBuckets: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageEnabled())
     *   ->withBuckets(...)
     *   ->withRetiredBuckets(...)
     *   ->withStatus(...)
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
     *
     * @param array<string,BetaGoogleManagedProjectStorageBucket|BetaGoogleManagedProjectStorageBucketShape> $buckets
     * @param list<BetaGoogleManagedProjectRetiredBucket|BetaGoogleManagedProjectRetiredBucketShape> $retiredBuckets
     * @param array<string,BetaGoogleManagedProjectStorageRegionStatusShape> $status
     */
    public static function with(
        array $buckets,
        array $retiredBuckets,
        array $status
    ): self {
        $self = new self;

        $self['buckets'] = $buckets;
        $self['retiredBuckets'] = $retiredBuckets;
        $self['status'] = $status;

        return $self;
    }

    /**
     * The bucket configured for each region, keyed by region code. A region with no bucket is left out.
     *
     * @param array<string,BetaGoogleManagedProjectStorageBucket|BetaGoogleManagedProjectStorageBucketShape> $buckets
     */
    public function withBuckets(array $buckets): self
    {
        $self = clone $this;
        $self['buckets'] = $buckets;

        return $self;
    }

    /**
     * Buckets that a region has retired, earliest `expires_at` first.
     *
     * @param list<BetaGoogleManagedProjectRetiredBucket|BetaGoogleManagedProjectRetiredBucketShape> $retiredBuckets
     */
    public function withRetiredBuckets(array $retiredBuckets): self
    {
        $self = clone $this;
        $self['retiredBuckets'] = $retiredBuckets;

        return $self;
    }

    /**
     * Each region's status for the control, keyed by region code. A region that your organization is not offered may have no entry, and Anthropic may add regions.
     *
     * @param array<string,BetaGoogleManagedProjectStorageRegionStatusShape> $status
     */
    public function withStatus(array $status): self
    {
        $self = clone $this;
        $self['status'] = $status;

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
}
