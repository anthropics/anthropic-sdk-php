<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has withdrawn or paused its approval of customer-owned storage for this profile, so the region does not apply the control.
 *
 * @phpstan-import-type BetaGoogleManagedBucketReferenceShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedBucketReference
 *
 * @phpstan-type BetaGoogleManagedStorageRegionSuspendedShape = array{
 *   effectiveBucket: null|BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape,
 *   type: 'suspended',
 * }
 */
final class BetaGoogleManagedStorageRegionSuspended implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageRegionSuspendedShape> */
    use SdkModel;

    /** @var 'suspended' $type */
    #[Required(type: new ConstantOf('suspended'))]
    public string $type = 'suspended';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedBucketReference $effectiveBucket;

    /**
     * `new BetaGoogleManagedStorageRegionSuspended()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedStorageRegionSuspended::with(effectiveBucket: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedStorageRegionSuspended())->withEffectiveBucket(...)
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
     */
    public static function with(
        BetaGoogleManagedBucketReference|array|null $effectiveBucket
    ): self {
        $self = new self;

        $self['effectiveBucket'] = $effectiveBucket;

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
     * @param 'suspended' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
