<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The control is on and has a bucket for at least one region.
 *
 * @phpstan-import-type BetaGoogleManagedStorageBucketShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageBucket
 * @phpstan-import-type BetaGoogleManagedRetiredBucketShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedRetiredBucket
 * @phpstan-import-type BetaGoogleManagedStorageRegionStatusShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageRegionStatus
 * @phpstan-import-type BetaGoogleManagedStorageRegionStatusVariants from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageRegionStatus
 *
 * @phpstan-type BetaGoogleManagedStorageEnabledShape = array{
 *   buckets: array<string,BetaGoogleManagedStorageBucket|BetaGoogleManagedStorageBucketShape>,
 *   retiredBuckets: list<BetaGoogleManagedRetiredBucket|BetaGoogleManagedRetiredBucketShape>,
 *   status: array<string,BetaGoogleManagedStorageRegionStatusShape>,
 *   type: 'enabled',
 * }
 */
final class BetaGoogleManagedStorageEnabled implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageEnabledShape> */
    use SdkModel;

    /** @var 'enabled' $type */
    #[Required(type: new ConstantOf('enabled'))]
    public string $type = 'enabled';

    /**
     * The bucket configured for each region, keyed by region code. A region with no bucket is left out.
     *
     * @var array<string,BetaGoogleManagedStorageBucket> $buckets
     */
    #[Required(map: BetaGoogleManagedStorageBucket::class)]
    public array $buckets;

    /**
     * Buckets that a region has retired, earliest `expires_at` first.
     *
     * @var list<BetaGoogleManagedRetiredBucket> $retiredBuckets
     */
    #[Required('retired_buckets', list: BetaGoogleManagedRetiredBucket::class)]
    public array $retiredBuckets;

    /**
     * Each region's status for the control, keyed by region code. A region that your organization is not offered may have no entry, and Anthropic may add regions.
     *
     * @var array<string,BetaGoogleManagedStorageRegionStatusVariants> $status
     */
    #[Required(map: BetaGoogleManagedStorageRegionStatus::class)]
    public array $status;

    /**
     * `new BetaGoogleManagedStorageEnabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedStorageEnabled::with(
     *   buckets: ..., retiredBuckets: ..., status: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedStorageEnabled())
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
     * @param array<string,BetaGoogleManagedStorageBucket|BetaGoogleManagedStorageBucketShape> $buckets
     * @param list<BetaGoogleManagedRetiredBucket|BetaGoogleManagedRetiredBucketShape> $retiredBuckets
     * @param array<string,BetaGoogleManagedStorageRegionStatusShape> $status
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
     * @param array<string,BetaGoogleManagedStorageBucket|BetaGoogleManagedStorageBucketShape> $buckets
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
     * @param list<BetaGoogleManagedRetiredBucket|BetaGoogleManagedRetiredBucketShape> $retiredBuckets
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
     * @param array<string,BetaGoogleManagedStorageRegionStatusShape> $status
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
