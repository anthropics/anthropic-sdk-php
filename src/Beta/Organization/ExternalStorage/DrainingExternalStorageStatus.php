<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * No Workspace has the storage attached. A Workspace can attach it again, unless
 * `removal_started` is true.
 *
 * @phpstan-type DrainingExternalStorageStatusShape = array{
 *   healthy: bool,
 *   lastCheckedAt: \DateTimeInterface,
 *   removalStarted: bool,
 *   type: 'draining',
 * }
 */
final class DrainingExternalStorageStatus implements BaseModel
{
    /** @use SdkModel<DrainingExternalStorageStatusShape> */
    use SdkModel;

    /** @var 'draining' $type */
    #[Required(type: new ConstantOf('draining'))]
    public string $type = 'draining';

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
     * True once a delete has started removing this storage, which can't be undone. It then can't be attached, and another delete finishes the removal.
     */
    #[Required('removal_started')]
    public bool $removalStarted;

    /**
     * `new DrainingExternalStorageStatus()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * DrainingExternalStorageStatus::with(
     *   healthy: ..., lastCheckedAt: ..., removalStarted: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new DrainingExternalStorageStatus())
     *   ->withHealthy(...)
     *   ->withLastCheckedAt(...)
     *   ->withRemovalStarted(...)
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
        \DateTimeInterface $lastCheckedAt,
        bool $removalStarted = false,
    ): self {
        $self = new self;

        $self['healthy'] = $healthy;
        $self['lastCheckedAt'] = $lastCheckedAt;
        $self['removalStarted'] = $removalStarted;

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
     * True once a delete has started removing this storage, which can't be undone. It then can't be attached, and another delete finishes the removal.
     */
    public function withRemovalStarted(bool $removalStarted): self
    {
        $self = clone $this;
        $self['removalStarted'] = $removalStarted;

        return $self;
    }

    /**
     * @param 'draining' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
