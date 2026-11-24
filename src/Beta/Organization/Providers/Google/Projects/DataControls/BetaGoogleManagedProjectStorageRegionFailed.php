<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The region stopped retrying verification before the configured bucket passed. To restart verification, send the region a bucket again. It can be the same bucket.
 *
 * @phpstan-import-type BetaGoogleManagedProjectEffectiveBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectEffectiveBucket
 * @phpstan-import-type BetaGoogleManagedProjectStorageFailedCheckShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageFailedCheck
 *
 * @phpstan-type BetaGoogleManagedProjectStorageRegionFailedShape = array{
 *   effectiveBucket: null|BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape,
 *   failedChecks: list<BetaGoogleManagedProjectStorageFailedCheck|BetaGoogleManagedProjectStorageFailedCheckShape>,
 *   type: 'failed',
 * }
 */
final class BetaGoogleManagedProjectStorageRegionFailed implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageRegionFailedShape> */
    use SdkModel;

    /** @var 'failed' $type */
    #[Required(type: new ConstantOf('failed'))]
    public string $type = 'failed';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedProjectEffectiveBucket $effectiveBucket;

    /**
     * The checks that the last reported verification attempt failed.
     *
     * @var list<BetaGoogleManagedProjectStorageFailedCheck> $failedChecks
     */
    #[Required(
        'failed_checks',
        list: BetaGoogleManagedProjectStorageFailedCheck::class
    )]
    public array $failedChecks;

    /**
     * `new BetaGoogleManagedProjectStorageRegionFailed()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageRegionFailed::with(
     *   effectiveBucket: ..., failedChecks: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageRegionFailed())
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
     * The checks that the last reported verification attempt failed.
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
     * @param 'failed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
