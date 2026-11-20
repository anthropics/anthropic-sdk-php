<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * The storage is verified, no Workspace has it attached, and Anthropic doesn't use
 * the bucket.
 *
 * @phpstan-type AvailableExternalStorageStatusShape = array{
 *   healthy: bool, lastCheckedAt: \DateTimeInterface, type: 'available'
 * }
 */
final class AvailableExternalStorageStatus implements BaseModel
{
    /** @use SdkModel<AvailableExternalStorageStatusShape> */
    use SdkModel;

    /** @var 'available' $type */
    #[Required(type: new ConstantOf('available'))]
    public string $type = 'available';

    /**
     * Whether the bucket passed its latest recorded check. It can stay `true` after the bucket stops working, so don't use it for monitoring.
     */
    #[Required]
    public bool $healthy;

    /**
     * When the bucket's latest recorded check ran, in RFC 3339.
     */
    #[Required('last_checked_at')]
    public \DateTimeInterface $lastCheckedAt;

    /**
     * `new AvailableExternalStorageStatus()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AvailableExternalStorageStatus::with(healthy: ..., lastCheckedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AvailableExternalStorageStatus())->withHealthy(...)->withLastCheckedAt(...)
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
     */
    public static function with(
        bool $healthy,
        \DateTimeInterface $lastCheckedAt
    ): self {
        $self = new self;

        $self['healthy'] = $healthy;
        $self['lastCheckedAt'] = $lastCheckedAt;

        return $self;
    }

    /**
     * Whether the bucket passed its latest recorded check. It can stay `true` after the bucket stops working, so don't use it for monitoring.
     */
    public function withHealthy(bool $healthy): self
    {
        $self = clone $this;
        $self['healthy'] = $healthy;

        return $self;
    }

    /**
     * When the bucket's latest recorded check ran, in RFC 3339.
     */
    public function withLastCheckedAt(\DateTimeInterface $lastCheckedAt): self
    {
        $self = clone $this;
        $self['lastCheckedAt'] = $lastCheckedAt;

        return $self;
    }

    /**
     * @param 'available' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
