<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has withdrawn or paused its approval of customer-owned storage for this project, so the region does not apply the control.
 *
 * @phpstan-import-type BetaGoogleManagedProjectEffectiveBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectEffectiveBucket
 *
 * @phpstan-type BetaGoogleManagedProjectStorageRegionSuspendedShape = array{
 *   effectiveBucket: null|BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape,
 *   type: 'suspended',
 * }
 */
final class BetaGoogleManagedProjectStorageRegionSuspended implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageRegionSuspendedShape> */
    use SdkModel;

    /** @var 'suspended' $type */
    #[Required(type: new ConstantOf('suspended'))]
    public string $type = 'suspended';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedProjectEffectiveBucket $effectiveBucket;

    /**
     * `new BetaGoogleManagedProjectStorageRegionSuspended()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageRegionSuspended::with(effectiveBucket: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageRegionSuspended())->withEffectiveBucket(...)
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
     */
    public static function with(
        BetaGoogleManagedProjectEffectiveBucket|array|null $effectiveBucket
    ): self {
        $self = new self;

        $self['effectiveBucket'] = $effectiveBucket;

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
     * @param 'suspended' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
