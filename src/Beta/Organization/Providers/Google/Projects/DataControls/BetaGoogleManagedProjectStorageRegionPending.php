<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The region is verifying the configured bucket.
 *
 * @phpstan-import-type BetaGoogleManagedProjectEffectiveBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectEffectiveBucket
 * @phpstan-import-type BetaGoogleManagedProjectStorageFailedCheckShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageFailedCheck
 *
 * @phpstan-type BetaGoogleManagedProjectStorageRegionPendingShape = array{
 *   effectiveBucket: null|BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape,
 *   failedChecks: list<BetaGoogleManagedProjectStorageFailedCheck|BetaGoogleManagedProjectStorageFailedCheckShape>,
 *   type: 'pending',
 * }
 */
final class BetaGoogleManagedProjectStorageRegionPending implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageRegionPendingShape> */
    use SdkModel;

    /** @var 'pending' $type */
    #[Required(type: new ConstantOf('pending'))]
    public string $type = 'pending';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedProjectEffectiveBucket $effectiveBucket;

    /**
     * The checks that the latest reported verification attempt failed. Empty when none has failed.
     *
     * @var list<BetaGoogleManagedProjectStorageFailedCheck> $failedChecks
     */
    #[Required(
        'failed_checks',
        list: BetaGoogleManagedProjectStorageFailedCheck::class
    )]
    public array $failedChecks;

    /**
     * `new BetaGoogleManagedProjectStorageRegionPending()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageRegionPending::with(
     *   effectiveBucket: ..., failedChecks: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageRegionPending())
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
     * @param BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape|null $effectiveBucket
     * @param list<BetaGoogleManagedProjectStorageFailedCheck|BetaGoogleManagedProjectStorageFailedCheckShape> $failedChecks
     */
    public static function with(
        BetaGoogleManagedProjectEffectiveBucket|array|null $effectiveBucket,
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
     * @param BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape|null $effectiveBucket
     */
    public function withEffectiveBucket(
        BetaGoogleManagedProjectEffectiveBucket|array|null $effectiveBucket
    ): self {
        $self = clone $this;
        $self['effectiveBucket'] = $effectiveBucket;

        return $self;
    }

    /**
     * The checks that the latest reported verification attempt failed. Empty when none has failed.
     *
     * @param list<BetaGoogleManagedProjectStorageFailedCheck|BetaGoogleManagedProjectStorageFailedCheckShape> $failedChecks
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
