<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No bucket is set for this region.
 *
 * @phpstan-import-type BetaGoogleManagedProjectEffectiveBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectEffectiveBucket
 *
 * @phpstan-type BetaGoogleManagedProjectStorageRegionNotConfiguredShape = array{
 *   effectiveBucket: null|BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape,
 *   type: 'not_configured',
 * }
 */
final class BetaGoogleManagedProjectStorageRegionNotConfigured implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageRegionNotConfiguredShape> */
    use SdkModel;

    /** @var 'not_configured' $type */
    #[Required(type: new ConstantOf('not_configured'))]
    public string $type = 'not_configured';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedProjectEffectiveBucket $effectiveBucket;

    /**
     * `new BetaGoogleManagedProjectStorageRegionNotConfigured()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageRegionNotConfigured::with(effectiveBucket: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageRegionNotConfigured())
     *   ->withEffectiveBucket(...)
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
     * @param 'not_configured' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
