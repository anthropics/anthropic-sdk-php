<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No bucket is set for this region.
 *
 * @phpstan-import-type BetaGoogleManagedBucketReferenceShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedBucketReference
 *
 * @phpstan-type BetaGoogleManagedStorageRegionNotConfiguredShape = array{
 *   effectiveBucket: null|BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape,
 *   type: 'not_configured',
 * }
 */
final class BetaGoogleManagedStorageRegionNotConfigured implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageRegionNotConfiguredShape> */
    use SdkModel;

    /** @var 'not_configured' $type */
    #[Required(type: new ConstantOf('not_configured'))]
    public string $type = 'not_configured';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedBucketReference $effectiveBucket;

    /**
     * `new BetaGoogleManagedStorageRegionNotConfigured()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedStorageRegionNotConfigured::with(effectiveBucket: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedStorageRegionNotConfigured())->withEffectiveBucket(...)
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
     * @param 'not_configured' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
