<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The configured bucket passed verification, and the region applies it.
 *
 * @phpstan-import-type BetaGoogleManagedBucketReferenceShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedBucketReference
 * @phpstan-import-type BetaGoogleManagedStorageFailedCheckShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedStorageFailedCheck
 *
 * @phpstan-type BetaGoogleManagedStorageRegionActiveShape = array{
 *   effectiveBucket: null|BetaGoogleManagedBucketReference|BetaGoogleManagedBucketReferenceShape,
 *   failedChecks: list<BetaGoogleManagedStorageFailedCheck|BetaGoogleManagedStorageFailedCheckShape>,
 *   type: 'active',
 *   validatedAt: \DateTimeInterface,
 * }
 */
final class BetaGoogleManagedStorageRegionActive implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageRegionActiveShape> */
    use SdkModel;

    /** @var 'active' $type */
    #[Required(type: new ConstantOf('active'))]
    public string $type = 'active';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedBucketReference $effectiveBucket;

    /**
     * The checks that the latest reported daily verification failed. Empty when it passed.
     *
     * @var list<BetaGoogleManagedStorageFailedCheck> $failedChecks
     */
    #[Required('failed_checks', list: BetaGoogleManagedStorageFailedCheck::class)]
    public array $failedChecks;

    /**
     * When the status last became `active`, in RFC 3339 format.
     */
    #[Required('validated_at')]
    public \DateTimeInterface $validatedAt;

    /**
     * `new BetaGoogleManagedStorageRegionActive()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedStorageRegionActive::with(
     *   effectiveBucket: ..., failedChecks: ..., validatedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedStorageRegionActive())
     *   ->withEffectiveBucket(...)
     *   ->withFailedChecks(...)
     *   ->withValidatedAt(...)
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
        \DateTimeInterface $validatedAt,
    ): self {
        $self = new self;

        $self['effectiveBucket'] = $effectiveBucket;
        $self['failedChecks'] = $failedChecks;
        $self['validatedAt'] = $validatedAt;

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
     * The checks that the latest reported daily verification failed. Empty when it passed.
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
     * @param 'active' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When the status last became `active`, in RFC 3339 format.
     */
    public function withValidatedAt(\DateTimeInterface $validatedAt): self
    {
        $self = clone $this;
        $self['validatedAt'] = $validatedAt;

        return $self;
    }
}
