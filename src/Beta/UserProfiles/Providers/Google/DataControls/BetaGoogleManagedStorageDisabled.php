<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles\Providers\Google\DataControls;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The control is off and has no buckets.
 *
 * @phpstan-import-type BetaGoogleManagedRetiredBucketShape from \Anthropic\Beta\UserProfiles\Providers\Google\DataControls\BetaGoogleManagedRetiredBucket
 *
 * @phpstan-type BetaGoogleManagedStorageDisabledShape = array{
 *   retiredBuckets: list<BetaGoogleManagedRetiredBucket|BetaGoogleManagedRetiredBucketShape>,
 *   type: 'disabled',
 * }
 */
final class BetaGoogleManagedStorageDisabled implements BaseModel
{
    /** @use SdkModel<BetaGoogleManagedStorageDisabledShape> */
    use SdkModel;

    /** @var 'disabled' $type */
    #[Required(type: new ConstantOf('disabled'))]
    public string $type = 'disabled';

    /**
     * Buckets that a region has retired, earliest `expires_at` first.
     *
     * @var list<BetaGoogleManagedRetiredBucket> $retiredBuckets
     */
    #[Required('retired_buckets', list: BetaGoogleManagedRetiredBucket::class)]
    public array $retiredBuckets;

    /**
     * `new BetaGoogleManagedStorageDisabled()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaGoogleManagedStorageDisabled::with(retiredBuckets: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaGoogleManagedStorageDisabled())->withRetiredBuckets(...)
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
     * @param list<BetaGoogleManagedRetiredBucket|BetaGoogleManagedRetiredBucketShape> $retiredBuckets
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
     * @param list<BetaGoogleManagedRetiredBucket|BetaGoogleManagedRetiredBucketShape> $retiredBuckets
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
