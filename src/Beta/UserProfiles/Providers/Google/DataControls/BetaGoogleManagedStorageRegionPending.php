<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The region is verifying the configured bucket.
 *
 * @phpstan-import-type BetaGoogleManagedBucketReferenceShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedBucketReference
 * @phpstan-import-type BetaGoogleManagedStorageFailedCheckShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageFailedCheck
 *
 * @phpstan-type BetaGoogleManagedStorageRegionPendingShape = array{
 *   effectiveBucket: null|BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape,
 *   failedChecks: list<BetaGoogleManagedStorageFailedCheck|BetaGoogleManagedStorageFailedCheckShape>,
 *   type: 'pending',
 * }
 */
final class BetaGoogleManagedStorageRegionPending implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageRegionPendingShape> */
    use SdkModel;

    /** @var 'pending' $type */
    #[Required(type: new ConstantOf('pending'))]
    public string $type = 'pending';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedBucketReference $effectiveBucket;

    /**
     * The checks that the latest reported verification attempt failed. Empty when none has failed.
     *
     * @var list<BetaGoogleManagedStorageFailedCheck> $failedChecks
     */
    #[Required('failed_checks', list: BetaGoogleManagedStorageFailedCheck::class)]
    public array $failedChecks;

    /**
     * `new BetaGoogleManagedStorageRegionPending()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedStorageRegionPending::with(
     *   effectiveBucket: ..., failedChecks: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedStorageRegionPending())
     *   ->withEffectiveBucket(...)
     *   ->withFailedChecks(...)
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
     * @param BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape|null $effectiveBucket
     * @param list<BetaGoogleManagedStorageFailedCheck|BetaGoogleManagedStorageFailedCheckShape> $failedChecks
     */
    public static function with(
        BetaGoogleManagedBucketReference|array|null $effectiveBucket,
        array $failedChecks,
    ): self {
        $self = new self;

        $self['effectiveBucket'] = $effectiveBucket;
        $self['failedChecks'] = $failedChecks;

        return $self;
    }

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     *
     * @param BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape|null $effectiveBucket
     */
    public function withEffectiveBucket(
        BetaGoogleManagedBucketReference|array|null $effectiveBucket
    ): self {
        $self = clone $this;
        $self['effectiveBucket'] = $effectiveBucket;

        return $self;
    }

    /**
     * The checks that the latest reported verification attempt failed. Empty when none has failed.
     *
     * @param list<BetaGoogleManagedStorageFailedCheck|BetaGoogleManagedStorageFailedCheckShape> $failedChecks
     */
    public function withFailedChecks(array $failedChecks): self
    {
        $self = clone $this;
        $self['failedChecks'] = $failedChecks;

        return $self;
    }

    /**
     * @param 'pending' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
