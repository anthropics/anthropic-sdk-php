<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Providers\Google\Projects\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The control is off and has no buckets.
 *
 * @phpstan-import-type BetaGoogleManagedProjectRetiredBucketShape from \Anthropic\Beta\Organization\Providers\Google\Projects\DataControls\BetaGoogleManagedProjectRetiredBucket
 *
 * @phpstan-type BetaGoogleManagedProjectStorageDisabledShape = array{
 *   retiredBuckets: list<BetaGoogleManagedProjectRetiredBucket|BetaGoogleManagedProjectRetiredBucketShape>,
 *   type: 'disabled',
 * }
 */
final class BetaGoogleManagedProjectStorageDisabled implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedProjectStorageDisabledShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required(type: new ConstantOf('disabled'))]
    public string $type = 'disabled';

    /**
     * Buckets that a region has retired, earliest `expires_at` first.
     *
     * @var list<BetaGoogleManagedProjectRetiredBucket> $retiredBuckets
     */
    #[Required(
        'retired_buckets',
        list: BetaGoogleManagedProjectRetiredBucket::class
    )]
    public array $retiredBuckets;

    /**
     * `new BetaGoogleManagedProjectStorageDisabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedProjectStorageDisabled::with(retiredBuckets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedProjectStorageDisabled())->withRetiredBuckets(...)
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
     * @param list<BetaGoogleManagedProjectRetiredBucket|BetaGoogleManagedProjectRetiredBucketShape> $retiredBuckets
     */
    public static function with(array $retiredBuckets): self
    {
        $self = new self;

        $self['retiredBuckets'] = $retiredBuckets;

        return $self;
    }

    /**
     * Buckets that a region has retired, earliest `expires_at` first.
     *
     * @param list<BetaGoogleManagedProjectRetiredBucket|BetaGoogleManagedProjectRetiredBucketShape> $retiredBuckets
     */
    public function withRetiredBuckets(array $retiredBuckets): self
    {
        $self = clone $this;
        $self['retiredBuckets'] = $retiredBuckets;

        return $self;
    }

    /**
     * @param 'disabled' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
