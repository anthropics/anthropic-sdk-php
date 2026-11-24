<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The configured bucket passed verification, and the region applies it.
 *
 * @phpstan-import-type BetaGoogleManagedProjectEffectiveBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectEffectiveBucket
 * @phpstan-import-type BetaGoogleManagedProjectStorageFailedCheckShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectStorageFailedCheck
 *
 * @phpstan-type BetaGoogleManagedProjectStorageRegionActiveShape = array{
 *   effectiveBucket: null|BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape,
 *   failedChecks: list<BetaGoogleManagedProjectStorageFailedCheck|BetaGoogleManagedProjectStorageFailedCheckShape>,
 *   type: 'active',
 *   validatedAt: \DateTimeInterface,
 * }
 */
final class BetaGoogleManagedProjectStorageRegionActive implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageRegionActiveShape> */
    use SdkModel;

    /** @var 'active' $type */
    #[Required(type: new ConstantOf('active'))]
    public string $type = 'active';

    /**
     * The bucket that the region applies now. While a replacement bucket is `pending` or `failed`, this is the previous bucket. `null` when the region applies no bucket.
     */
    #[Required('effective_bucket')]
    public ?BetaGoogleManagedProjectEffectiveBucket $effectiveBucket;

    /**
     * The checks that the latest reported daily verification failed. Empty when it passed.
     *
     * @var list<BetaGoogleManagedProjectStorageFailedCheck> $failedChecks
     */
    #[Required(
        'failed_checks',
        list: BetaGoogleManagedProjectStorageFailedCheck::class
    )]
    public array $failedChecks;

    /**
     * When the status last became `active`, in RFC 3339 format.
     */
    #[Required('validated_at')]
    public \DateTimeInterface $validatedAt;

    /**
     * `new BetaGoogleManagedProjectStorageRegionActive()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageRegionActive::with(
     *   effectiveBucket: ..., failedChecks: ..., validatedAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageRegionActive())
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
     * @param BetaGoogleManagedProjectEffectiveBucket|BetaGoogleManagedProjectEffectiveBucketShape|null $effectiveBucket
     * @param list<BetaGoogleManagedProjectStorageFailedCheck|BetaGoogleManagedProjectStorageFailedCheckShape> $failedChecks
     */
    public static function with(
        BetaGoogleManagedProjectEffectiveBucket|array|null $effectiveBucket,
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
     * The checks that the latest reported daily verification failed. Empty when it passed.
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
